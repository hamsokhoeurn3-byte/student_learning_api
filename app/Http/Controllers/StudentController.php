<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->get();

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
            'email' => 'required|email|max:255|unique:students,email',

            'department' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:20',
            'year_level' => 'nullable|integer|min:1|max:10',
            'semester' => 'nullable|string|max:50',

            'advisor' => 'nullable|string|max:255',
            'enrollment_date' => 'nullable|date',
            'status' => 'nullable|string|max:50',
        ]);

        $student = Student::create($validated);

        return response()->json([
            'message' => 'Student created successfully.',
            'data' => $student,
        ], 201);
    }

    public function show(Student $student)
    {
        return response()->json([
            'message' => 'Student retrieved successfully.',
            'data' => $student,
        ], 200);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([

            'student_id' => 'required|string|max:50|unique:students,student_id,' . $student->id,

            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',

            'gender' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:100',

            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,

            'department' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:20',
            'year_level' => 'nullable|integer|min:1|max:10',
            'semester' => 'nullable|string|max:50',

            'advisor' => 'nullable|string|max:255',
            'enrollment_date' => 'nullable|date',
            'status' => 'nullable|string|max:50',
        ]);

        $student->update($validated);

        return response()->json([
            'message' => 'Student updated successfully.',
            'data' => $student,
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