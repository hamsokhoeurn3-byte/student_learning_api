<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->latest()->get();

        return response()->json([
            'message' => 'Students retrieved successfully.',
            'data' => $students,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|string|max:50|unique:students,student_id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => 'required|string|min:8|confirmed',
            'department' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:20',
            'year_level' => 'nullable|integer|min:1|max:10',
            'semester' => 'nullable|string|max:50',
            'advisor' => 'nullable|string|max:255',
            'enrollment_date' => 'nullable|date',
            'status' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'student_id' => $validated['student_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender' => $validated['gender'],
            'nationality' => $validated['nationality'] ?? 'Cambodian',
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'department' => $validated['department'] ?? null,
            'major' => $validated['major'] ?? null,
            'academic_year' => $validated['academic_year'] ?? null,
            'year_level' => $validated['year_level'] ?? null,
            'semester' => $validated['semester'] ?? null,
            'advisor' => $validated['advisor'] ?? null,
            'enrollment_date' => $validated['enrollment_date'] ?? null,
            'status' => $validated['status'] ?? 'enrolled',
        ]);

        return response()->json([
            'message' => 'Student created successfully.',
            'user' => $user,
            'data' => $student->load('user'),
        ], 201);
    }

    public function show(Student $student)
    {
        return response()->json([
            'message' => 'Student retrieved successfully.',
            'data' => $student->load('user'),
        ], 200);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'string', 'max:50', Rule::unique('students', 'student_id')->ignore($student->id)],
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($student->user?->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'department' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:20',
            'year_level' => 'nullable|integer|min:1|max:10',
            'semester' => 'nullable|string|max:50',
            'advisor' => 'nullable|string|max:255',
            'enrollment_date' => 'nullable|date',
            'status' => 'nullable|string|max:50',
        ]);

        if ($student->user) {
            if (isset($validated['email'])) {
                $student->user->email = $validated['email'];
            }

            if (isset($validated['password'])) {
                $student->user->password = Hash::make($validated['password']);
            }

            $student->user->name = trim(($validated['first_name'] ?? $student->first_name) . ' ' . ($validated['last_name'] ?? $student->last_name));
            $student->user->save();
        }

        $student->fill([
            'student_id' => $validated['student_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'] ?? $student->date_of_birth,
            'gender' => $validated['gender'],
            'nationality' => $validated['nationality'] ?? $student->nationality,
            'phone' => $validated['phone'] ?? $student->phone,
            'address' => $validated['address'] ?? $student->address,
            'department' => $validated['department'] ?? $student->department,
            'major' => $validated['major'] ?? $student->major,
            'academic_year' => $validated['academic_year'] ?? $student->academic_year,
            'year_level' => $validated['year_level'] ?? $student->year_level,
            'semester' => $validated['semester'] ?? $student->semester,
            'advisor' => $validated['advisor'] ?? $student->advisor,
            'enrollment_date' => $validated['enrollment_date'] ?? $student->enrollment_date,
            'status' => $validated['status'] ?? $student->status,
        ]);
        $student->save();

        return response()->json([
            'message' => 'Student updated successfully.',
            'user' => $student->user,
            'data' => $student->fresh()->load('user'),
        ], 200);
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully.',
        ], 200);
    }
}
