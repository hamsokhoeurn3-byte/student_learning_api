<?php

namespace App\Http\Controllers;

use App\Models\CourseEnrollment;
use Illuminate\Http\Request;

class CourseEnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = CourseEnrollment::with(['student.user', 'course', 'semester']);

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->has('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        $enrollments = $query->latest()->get();

        return response()->json([
            'message' => 'Course enrollments retrieved successfully.',
            'data' => $enrollments,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'course_id' => 'required|integer|exists:courses,id',
            'semester_id' => 'required|integer|exists:semesters,id',
            'enrollment_date' => 'nullable|date',
            'status' => 'nullable|string|in:enrolled,completed,dropped,failed',
        ]);

        $enrollment = CourseEnrollment::create([
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id'],
            'semester_id' => $validated['semester_id'],
            'enrollment_date' => $validated['enrollment_date'] ?? now()->toDateString(),
            'status' => $validated['status'] ?? 'enrolled',
        ]);

        return response()->json([
            'message' => 'Student enrolled successfully.',
            'data' => $enrollment->load(['student', 'course', 'semester']),
        ], 201);
    }

    public function show(CourseEnrollment $courseEnrollment)
    {
        return response()->json([
            'message' => 'Course enrollment retrieved successfully.',
            'data' => $courseEnrollment->load(['student.user', 'course', 'semester']),
        ], 200);
    }

    public function update(Request $request, CourseEnrollment $courseEnrollment)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:enrolled,completed,dropped,failed',
            'final_score' => 'nullable|numeric|min:0|max:100',
            'grade' => 'nullable|string|max:10',
        ]);

        $courseEnrollment->update($validated);

        return response()->json([
            'message' => 'Course enrollment updated successfully.',
            'data' => $courseEnrollment->fresh()->load(['student', 'course', 'semester']),
        ], 200);
    }

    public function destroy(CourseEnrollment $courseEnrollment)
    {
        $courseEnrollment->delete();

        return response()->json([
            'message' => 'Course enrollment deleted successfully.',
        ], 200);
    }
}
