<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $query = Quiz::with(['course', 'teacher', 'semester']);

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->has('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->has('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        $quizzes = $query->latest()->get();

        return response()->json([
            'message' => 'Quizzes retrieved successfully.',
            'data' => $quizzes,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|integer|exists:courses,id',
            'teacher_id' => 'required|integer|exists:teachers,id',
            'semester_id' => 'required|integer|exists:semesters,id',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'total_score' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'status' => 'nullable|string|in:draft,published,open,closed',
        ]);

        $quiz = Quiz::create([
            'course_id' => $validated['course_id'],
            'teacher_id' => $validated['teacher_id'],
            'semester_id' => $validated['semester_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'total_score' => $validated['total_score'],
            'duration_minutes' => $validated['duration_minutes'],
            'start_at' => $validated['start_at'] ?? null,
            'end_at' => $validated['end_at'] ?? null,
            'status' => $validated['status'] ?? 'published',
        ]);

        return response()->json([
            'message' => 'Quiz created successfully.',
            'data' => $quiz->load(['course', 'teacher', 'semester']),
        ], 201);
    }

    public function show(Quiz $quiz)
    {
        return response()->json([
            'message' => 'Quiz retrieved successfully.',
            'data' => $quiz->load(['course', 'teacher', 'semester', 'questions']),
        ], 200);
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'total_score' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'status' => 'nullable|string|in:draft,published,open,closed',
        ]);

        $quiz->update($validated);

        return response()->json([
            'message' => 'Quiz updated successfully.',
            'data' => $quiz->fresh()->load(['course', 'teacher', 'semester']),
        ], 200);
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return response()->json([
            'message' => 'Quiz deleted successfully.',
        ], 200);
    }
}
