<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function index(Request $request)
    {
        $query = Recommendation::with(['student.user', 'course', 'semester']);

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $recommendations = $query->latest()->get();

        return response()->json([
            'message' => 'Recommendations retrieved successfully.',
            'data' => $recommendations,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'course_id' => 'nullable|integer|exists:courses,id',
            'semester_id' => 'nullable|integer|exists:semesters,id',
            'type' => 'nullable|string|max:30',
            'title' => 'required|string|max:200',
            'message' => 'required|string',
            'priority' => 'nullable|string|in:low,medium,high',
            'generated_by' => 'nullable|string|max:20',
        ]);

        $recommendation = Recommendation::create([
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id'] ?? null,
            'semester_id' => $validated['semester_id'] ?? null,
            'type' => $validated['type'] ?? 'general',
            'title' => $validated['title'],
            'message' => $validated['message'],
            'priority' => $validated['priority'] ?? 'medium',
            'status' => 'pending',
            'generated_by' => $validated['generated_by'] ?? 'system',
        ]);

        return response()->json([
            'message' => 'Recommendation created successfully.',
            'data' => $recommendation->load(['student', 'course']),
        ], 201);
    }

    public function show(Recommendation $recommendation)
    {
        return response()->json([
            'message' => 'Recommendation retrieved successfully.',
            'data' => $recommendation->load(['student.user', 'course', 'semester']),
        ], 200);
    }

    public function update(Request $request, Recommendation $recommendation)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,viewed,completed,dismissed',
        ]);

        $recommendation->update($validated);

        return response()->json([
            'message' => 'Recommendation updated successfully.',
            'data' => $recommendation->fresh()->load(['student', 'course']),
        ], 200);
    }

    public function destroy(Recommendation $recommendation)
    {
        $recommendation->delete();

        return response()->json([
            'message' => 'Recommendation deleted successfully.',
        ], 200);
    }
}
