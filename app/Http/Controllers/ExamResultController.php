<?php

namespace App\Http\Controllers;

use App\Models\ExamResult;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    public function index(Request $request)
    {
        $query = ExamResult::with(['exam.course', 'student.user']);

        if ($request->has('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $results = $query->latest()->get();

        return response()->json([
            'message' => 'Exam results retrieved successfully.',
            'data' => $results,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|integer|exists:exams,id',
            'student_id' => 'required|integer|exists:students,id',
            'score' => 'required|numeric|min:0',
            'grade' => 'nullable|string|max:10',
            'remarks' => 'nullable|string|max:255',
        ]);

        $result = ExamResult::updateOrCreate(
            [
                'exam_id' => $validated['exam_id'],
                'student_id' => $validated['student_id'],
            ],
            [
                'score' => $validated['score'],
                'grade' => $validated['grade'] ?? null,
                'remarks' => $validated['remarks'] ?? null,
            ]
        );

        return response()->json([
            'message' => 'Exam result recorded successfully.',
            'data' => $result->load(['exam', 'student']),
        ], 201);
    }

    public function show(ExamResult $examResult)
    {
        return response()->json([
            'message' => 'Exam result retrieved successfully.',
            'data' => $examResult->load(['exam.course', 'student.user']),
        ], 200);
    }

    public function update(Request $request, ExamResult $examResult)
    {
        $validated = $request->validate([
            'score' => 'required|numeric|min:0',
            'grade' => 'nullable|string|max:10',
            'remarks' => 'nullable|string|max:255',
        ]);

        $examResult->update($validated);

        return response()->json([
            'message' => 'Exam result updated successfully.',
            'data' => $examResult->fresh()->load(['exam', 'student']),
        ], 200);
    }

    public function destroy(ExamResult $examResult)
    {
        $examResult->delete();

        return response()->json([
            'message' => 'Exam result deleted successfully.',
        ], 200);
    }
}
