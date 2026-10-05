<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizAttemptController extends Controller
{
    public function index(Request $request)
    {
        $query = QuizAttempt::with(['quiz.course', 'student.user']);

        if ($request->has('quiz_id')) {
            $query->where('quiz_id', $request->quiz_id);
        }

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $attempts = $query->latest()->get();

        return response()->json([
            'message' => 'Quiz attempts retrieved successfully.',
            'data' => $attempts,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|integer|exists:quizzes,id',
            'student_id' => 'required|integer|exists:students,id',
            'started_at' => 'nullable|date',
        ]);

        $nextAttemptNumber = QuizAttempt::where('quiz_id', $validated['quiz_id'])
            ->where('student_id', $validated['student_id'])
            ->count() + 1;

        $attempt = QuizAttempt::create([
            'quiz_id' => $validated['quiz_id'],
            'student_id' => $validated['student_id'],
            'attempt_number' => $nextAttemptNumber,
            'started_at' => $validated['started_at'] ?? now(),
            'status' => 'in_progress',
        ]);

        return response()->json([
            'message' => 'Quiz attempt started successfully.',
            'data' => $attempt->load(['quiz', 'student']),
        ], 201);
    }

    public function show(QuizAttempt $quizAttempt)
    {
        return response()->json([
            'message' => 'Quiz attempt retrieved successfully.',
            'data' => $quizAttempt->load(['quiz.questions', 'student.user', 'answers.question']),
        ], 200);
    }

    public function update(Request $request, QuizAttempt $quizAttempt)
    {
        $validated = $request->validate([
            'score' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:in_progress,completed,timed_out',
            'submitted_at' => 'nullable|date',
        ]);

        $quizAttempt->update([
            'score' => $validated['score'] ?? $quizAttempt->score,
            'status' => $validated['status'] ?? 'completed',
            'submitted_at' => $validated['submitted_at'] ?? now(),
        ]);

        return response()->json([
            'message' => 'Quiz attempt submitted/updated successfully.',
            'data' => $quizAttempt->fresh()->load(['quiz', 'student', 'answers']),
        ], 200);
    }

    public function destroy(QuizAttempt $quizAttempt)
    {
        $quizAttempt->delete();

        return response()->json([
            'message' => 'Quiz attempt deleted successfully.',
        ], 200);
    }
}
