<?php

namespace App\Http\Controllers;

use App\Models\PerformanceRecord;
use Illuminate\Http\Request;

class PerformanceRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = PerformanceRecord::with(['student.user', 'course', 'semester']);

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->has('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        $records = $query->latest()->get();

        return response()->json([
            'message' => 'Performance records retrieved successfully.',
            'data' => $records,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'course_id' => 'required|integer|exists:courses,id',
            'semester_id' => 'required|integer|exists:semesters,id',
            'period_type' => 'nullable|string|in:weekly,monthly,semester,yearly',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
            'attendance_percentage' => 'nullable|numeric|min:0|max:100',
            'assignment_percentage' => 'nullable|numeric|min:0|max:100',
            'quiz_percentage' => 'nullable|numeric|min:0|max:100',
            'exam_percentage' => 'nullable|numeric|min:0|max:100',
            'overall_score' => 'nullable|numeric|min:0|max:100',
            'performance_level' => 'nullable|string|max:50',
        ]);

        $record = PerformanceRecord::create([
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id'],
            'semester_id' => $validated['semester_id'],
            'period_type' => $validated['period_type'] ?? 'semester',
            'period_start' => $validated['period_start'],
            'period_end' => $validated['period_end'],
            'attendance_percentage' => $validated['attendance_percentage'] ?? null,
            'assignment_percentage' => $validated['assignment_percentage'] ?? null,
            'quiz_percentage' => $validated['quiz_percentage'] ?? null,
            'exam_percentage' => $validated['exam_percentage'] ?? null,
            'overall_score' => $validated['overall_score'] ?? null,
            'performance_level' => $validated['performance_level'] ?? null,
        ]);

        return response()->json([
            'message' => 'Performance record created successfully.',
            'data' => $record->load(['student', 'course', 'semester']),
        ], 201);
    }

    public function show(PerformanceRecord $performanceRecord)
    {
        return response()->json([
            'message' => 'Performance record retrieved successfully.',
            'data' => $performanceRecord->load(['student.user', 'course', 'semester']),
        ], 200);
    }

    public function update(Request $request, PerformanceRecord $performanceRecord)
    {
        $validated = $request->validate([
            'attendance_percentage' => 'nullable|numeric|min:0|max:100',
            'assignment_percentage' => 'nullable|numeric|min:0|max:100',
            'quiz_percentage' => 'nullable|numeric|min:0|max:100',
            'exam_percentage' => 'nullable|numeric|min:0|max:100',
            'overall_score' => 'nullable|numeric|min:0|max:100',
            'performance_level' => 'nullable|string|max:50',
        ]);

        $performanceRecord->update($validated);

        return response()->json([
            'message' => 'Performance record updated successfully.',
            'data' => $performanceRecord->fresh()->load(['student', 'course', 'semester']),
        ], 200);
    }

    public function destroy(PerformanceRecord $performanceRecord)
    {
        $performanceRecord->delete();

        return response()->json([
            'message' => 'Performance record deleted successfully.',
        ], 200);
    }
}
