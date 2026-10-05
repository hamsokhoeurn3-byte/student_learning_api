<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::with(['student.user', 'course', 'semester']);

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->has('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        $grades = $query->latest()->get();

        return response()->json([
            'message' => 'Grades retrieved successfully.',
            'data' => $grades,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'course_id' => 'required|integer|exists:courses,id',
            'semester_id' => 'required|integer|exists:semesters,id',
            'assignment_score' => 'nullable|numeric|min:0|max:100',
            'quiz_score' => 'nullable|numeric|min:0|max:100',
            'attendance_score' => 'nullable|numeric|min:0|max:100',
            'midterm_score' => 'nullable|numeric|min:0|max:100',
            'final_exam_score' => 'nullable|numeric|min:0|max:100',
            'total_score' => 'nullable|numeric|min:0|max:100',
            'letter_grade' => 'nullable|string|max:5',
            'grade_point' => 'nullable|numeric|min:0|max:4.0',
            'status' => 'nullable|string|in:draft,submitted,finalized',
        ]);

        $grade = Grade::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'course_id' => $validated['course_id'],
                'semester_id' => $validated['semester_id'],
            ],
            $validated
        );

        return response()->json([
            'message' => 'Grade recorded successfully.',
            'data' => $grade->load(['student', 'course', 'semester']),
        ], 201);
    }

    public function show(Grade $grade)
    {
        return response()->json([
            'message' => 'Grade retrieved successfully.',
            'data' => $grade->load(['student.user', 'course', 'semester']),
        ], 200);
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'assignment_score' => 'nullable|numeric|min:0|max:100',
            'quiz_score' => 'nullable|numeric|min:0|max:100',
            'attendance_score' => 'nullable|numeric|min:0|max:100',
            'midterm_score' => 'nullable|numeric|min:0|max:100',
            'final_exam_score' => 'nullable|numeric|min:0|max:100',
            'total_score' => 'nullable|numeric|min:0|max:100',
            'letter_grade' => 'nullable|string|max:5',
            'grade_point' => 'nullable|numeric|min:0|max:4.0',
            'status' => 'nullable|string|in:draft,submitted,finalized',
        ]);

        $grade->update($validated);

        return response()->json([
            'message' => 'Grade updated successfully.',
            'data' => $grade->fresh()->load(['student', 'course', 'semester']),
        ], 200);
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return response()->json([
            'message' => 'Grade deleted successfully.',
        ], 200);
    }
}
