<?php

namespace App\Http\Controllers;

use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizAnswerController extends Controller
{
    public function index(Request $request)
    {
        $query = QuizAnswer::with(['attempt', 'question']);

        if ($request->has('quiz_attempt_id')) {
            $query->where('quiz_attempt_id', $request->quiz_attempt_id);
        }

        $answers = $query->get();

        return response()->json([
            'message' => 'Quiz answers retrieved successfully.',
            'data' => $answers,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quiz_attempt_id' => 'required|integer|exists:quiz_attempts,id',
            'question_id' => 'required|integer|exists:quiz_questions,id',
            'answer' => 'required|string',
        ]);

        $question = QuizQuestion::find($validated['question_id']);
        $isCorrect = false;
        $marksObtained = 0.0;

        if ($question && strtoupper(trim($validated['answer'])) === strtoupper(trim($question->correct_answer))) {
            $isCorrect = true;
            $marksObtained = (float) $question->marks;
        }

        $quizAnswer = QuizAnswer::updateOrCreate(
            [
                'quiz_attempt_id' => $validated['quiz_attempt_id'],
                'question_id' => $validated['question_id'],
            ],
            [
                'answer' => $validated['answer'],
                'is_correct' => $isCorrect,
                'marks_obtained' => $marksObtained,
            ]
        );

        return response()->json([
            'message' => 'Quiz answer recorded successfully.',
            'data' => $quizAnswer->load('question'),
        ], 201);
    }

    public function show(QuizAnswer $quizAnswer)
    {
        return response()->json([
            'message' => 'Quiz answer retrieved successfully.',
            'data' => $quizAnswer->load(['attempt', 'question']),
        ], 200);
    }

    public function update(Request $request, QuizAnswer $quizAnswer)
    {
        $validated = $request->validate([
            'answer' => 'required|string',
            'is_correct' => 'nullable|boolean',
            'marks_obtained' => 'nullable|numeric|min:0',
        ]);

        $quizAnswer->update($validated);

        return response()->json([
            'message' => 'Quiz answer updated successfully.',
            'data' => $quizAnswer->fresh(),
        ], 200);
    }

    public function destroy(QuizAnswer $quizAnswer)
    {
        $quizAnswer->delete();

        return response()->json([
            'message' => 'Quiz answer deleted successfully.',
        ], 200);
    }
}
