<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with(['user', 'department'])->latest()->get();

        return response()->json([
            'message' => 'Teachers retrieved successfully.',
            'data' => $teachers,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|string|max:50|unique:teachers,teacher_code',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => 'required|string|min:8|confirmed',
            'department_id' => 'required|integer|exists:departments,id',
            'position' => 'nullable|string|max:100',
            'specialization' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:30',
            'status' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
        ]);

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'teacher_code' => $validated['teacher_id'],
            'department_id' => $validated['department_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'position' => $validated['position'] ?? 'Lecturer',
            'specialization' => $validated['specialization'] ?? null,
            'gender' => $validated['gender'] ?? 'Male',
            'phone' => $validated['phone'] ?? null,
            'status' => $validated['status'] ?? 'active',
        ]);

        return response()->json([
            'message' => 'Teacher created successfully.',
            'user' => $user,
            'data' => $teacher->load(['user', 'department']),
        ], 201);
    }

    public function show(Teacher $teacher)
    {
        return response()->json([
            'message' => 'Teacher retrieved successfully.',
            'data' => $teacher->load(['user', 'department', 'courses']),
        ], 200);
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'teacher_id' => ['required', 'string', 'max:50', Rule::unique('teachers', 'teacher_code')->ignore($teacher->id)],
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($teacher->user?->id)],
            'department_id' => 'required|integer|exists:departments,id',
            'position' => 'nullable|string|max:100',
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'status' => 'nullable|string|max:50',
        ]);

        if ($teacher->user) {
            if (isset($validated['email'])) {
                $teacher->user->email = $validated['email'];
            }
            $teacher->user->name = trim($validated['first_name'] . ' ' . $validated['last_name']);
            $teacher->user->save();
        }

        $teacher->update([
            'teacher_code' => $validated['teacher_id'],
            'department_id' => $validated['department_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'position' => $validated['position'] ?? $teacher->position,
            'specialization' => $validated['specialization'] ?? $teacher->specialization,
            'phone' => $validated['phone'] ?? $teacher->phone,
            'status' => $validated['status'] ?? $teacher->status,
        ]);

        return response()->json([
            'message' => 'Teacher updated successfully.',
            'data' => $teacher->fresh()->load(['user', 'department']),
        ], 200);
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return response()->json([
            'message' => 'Teacher deleted successfully.',
        ], 200);
    }
}
