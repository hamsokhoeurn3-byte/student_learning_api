<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Services\AcademicProfileResolver;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'department', 'classRoom'])->latest()->get();

        return response()->json([
            'message' => 'Students retrieved successfully.',
            'data' => $students,
        ], 200);
    }

    public function store(Request $request, AcademicProfileResolver $resolver)
    {
        // The request key stays `student_id` (Android contract); stored in students.student_code.
        $validated = $request->validate([
            'student_id' => 'required|string|max:50|unique:students,student_code',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => 'required|string|min:8|confirmed',
            'department_id' => 'nullable|integer|exists:departments,id',
            'class_id' => 'nullable|integer|exists:classes,id',
            'department' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:20',
            'year_level' => 'nullable|integer|min:1|max:10',
            'semester' => 'nullable|string|max:50',
            'advisor' => 'nullable|string|max:255',
            'enrollment_date' => 'nullable|date',
            'status' => 'nullable|string|max:50',
        ]);

        $departmentId = $resolver->resolveDepartmentId(
            $validated['department_id'] ?? null,
            $validated['department'] ?? null,
        );

        $classId = $validated['class_id']
            ?? $resolver->findClassId($departmentId, $validated['academic_year'] ?? null, $validated['year_level'] ?? null);

        $user = User::create([
            'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'student_code' => $validated['student_id'],
            'department_id' => $departmentId,
            'class_id' => $classId,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender' => $validated['gender'],
            'nationality' => $validated['nationality'] ?? 'Cambodian',
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'major' => $validated['major'] ?? null,
            'year_level' => $validated['year_level'] ?? null,
            'advisor' => $validated['advisor'] ?? null,
            'enrollment_date' => $validated['enrollment_date'] ?? null,
            'status' => $validated['status'] ?? 'enrolled',
        ]);

        return response()->json([
            'message' => 'Student created successfully.',
            'user' => $user,
            'data' => $student->load(['user', 'department', 'classRoom']),
        ], 201);
    }

    public function show(Student $student)
    {
        return response()->json([
            'message' => 'Student retrieved successfully.',
            'data' => $student->load(['user', 'department', 'classRoom']),
        ], 200);
    }

    public function update(Request $request, Student $student, AcademicProfileResolver $resolver)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'string', 'max:50', Rule::unique('students', 'student_code')->ignore($student->id)],
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($student->user?->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'department_id' => 'nullable|integer|exists:departments,id',
            'class_id' => 'nullable|integer|exists:classes,id',
            'department' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:20',
            'year_level' => 'nullable|integer|min:1|max:10',
            'semester' => 'nullable|string|max:50',
            'advisor' => 'nullable|string|max:255',
            'enrollment_date' => 'nullable|date',
            'status' => 'nullable|string|max:50',
        ]);

        $departmentId = $resolver->resolveDepartmentId(
            $validated['department_id'] ?? null,
            $validated['department'] ?? null,
        ) ?? $student->department_id;

        $classId = $validated['class_id']
            ?? $resolver->findClassId(
                $departmentId,
                $validated['academic_year'] ?? null,
                $validated['year_level'] ?? null,
            )
            ?? $student->class_id;

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
            'student_code' => $validated['student_id'],
            'department_id' => $departmentId,
            'class_id' => $classId,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'] ?? $student->date_of_birth,
            'gender' => $validated['gender'],
            'nationality' => $validated['nationality'] ?? $student->nationality,
            'phone' => $validated['phone'] ?? $student->phone,
            'address' => $validated['address'] ?? $student->address,
            'major' => $validated['major'] ?? $student->major,
            'year_level' => $validated['year_level'] ?? $student->year_level,
            'advisor' => $validated['advisor'] ?? $student->advisor,
            'enrollment_date' => $validated['enrollment_date'] ?? $student->enrollment_date,
            'status' => $validated['status'] ?? $student->status,
        ]);
        $student->save();

        return response()->json([
            'message' => 'Student updated successfully.',
            'user' => $student->user,
            'data' => $student->fresh()->load(['user', 'department', 'classRoom']),
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
