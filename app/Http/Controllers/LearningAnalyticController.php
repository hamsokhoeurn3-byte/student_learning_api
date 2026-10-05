<?php

namespace App\Http\Controllers;

use App\Models\LearningAnalytic;
use Illuminate\Http\Request;

class LearningAnalyticController extends Controller
{
    public function index(Request $request)
    {
        $query = LearningAnalytic::with(['student.user', 'semester']);

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        $analytics = $query->latest('calculated_at')->get();

        return response()->json([
            'message' => 'Learning analytics retrieved successfully.',
            'data' => $analytics,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'semester_id' => 'nullable|integer|exists:semesters,id',
            'period_type' => 'nullable|string|in:weekly,monthly,semester,yearly',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
            'attendance_rate' => 'nullable|numeric|min:0|max:100',
            'assignment_average' => 'nullable|numeric|min:0|max:100',
            'quiz_average' => 'nullable|numeric|min:0|max:100',
            'exam_average' => 'nullable|numeric|min:0|max:100',
            'overall_performance' => 'nullable|numeric|min:0|max:100',
            'performance_change' => 'nullable|numeric',
            'learning_trend' => 'nullable|string|in:improving,stable,declining',
            'strengths' => 'nullable|array',
            'weaknesses' => 'nullable|array',
            'analytics_summary' => 'nullable|string',
        ]);

        $analytic = LearningAnalytic::create([
            'student_id' => $validated['student_id'],
            'semester_id' => $validated['semester_id'] ?? null,
            'period_type' => $validated['period_type'] ?? 'semester',
            'period_start' => $validated['period_start'],
            'period_end' => $validated['period_end'],
            'attendance_rate' => $validated['attendance_rate'] ?? null,
            'assignment_average' => $validated['assignment_average'] ?? null,
            'quiz_average' => $validated['quiz_average'] ?? null,
            'exam_average' => $validated['exam_average'] ?? null,
            'overall_performance' => $validated['overall_performance'] ?? null,
            'performance_change' => $validated['performance_change'] ?? 0.0,
            'learning_trend' => $validated['learning_trend'] ?? 'stable',
            'strengths' => isset($validated['strengths']) ? json_encode($validated['strengths']) : null,
            'weaknesses' => isset($validated['weaknesses']) ? json_encode($validated['weaknesses']) : null,
            'analytics_summary' => $validated['analytics_summary'] ?? null,
            'calculated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Learning analytic record created successfully.',
            'data' => $analytic->load(['student', 'semester']),
        ], 201);
    }

    public function show(LearningAnalytic $learningAnalytic)
    {
        return response()->json([
            'message' => 'Learning analytic retrieved successfully.',
            'data' => $learningAnalytic->load(['student.user', 'semester']),
        ], 200);
    }

    public function update(Request $request, LearningAnalytic $learningAnalytic)
    {
        $validated = $request->validate([
            'attendance_rate' => 'nullable|numeric|min:0|max:100',
            'assignment_average' => 'nullable|numeric|min:0|max:100',
            'quiz_average' => 'nullable|numeric|min:0|max:100',
            'exam_average' => 'nullable|numeric|min:0|max:100',
            'overall_performance' => 'nullable|numeric|min:0|max:100',
            'learning_trend' => 'nullable|string|in:improving,stable,declining',
            'analytics_summary' => 'nullable|string',
        ]);

        $learningAnalytic->update($validated);

        return response()->json([
            'message' => 'Learning analytic updated successfully.',
            'data' => $learningAnalytic->fresh()->load(['student', 'semester']),
        ], 200);
    }

    public function destroy(LearningAnalytic $learningAnalytic)
    {
        $learningAnalytic->delete();

        return response()->json([
            'message' => 'Learning analytic deleted successfully.',
        ], 200);
    }
}
