<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with(['course', 'teacher', 'semester']);

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->has('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->has('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        $exams = $query->latest()->get();

        return response()->json([
            'message' => 'Exams retrieved successfully.',
            'data' => $exams,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|integer|exists:courses,id',
            'teacher_id' => 'required|integer|exists:teachers,id',
            'semester_id' => 'required|integer|exists:semesters,id',
            'title' => 'required|string|max:200',
            'exam_type' => 'required|string|in:midterm,final,quiz,assignment',
            'exam_date' => 'required|date',
            'total_score' => 'required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:scheduled,ongoing,completed,cancelled',
        ]);

        $exam = Exam::create([
            'course_id' => $validated['course_id'],
            'teacher_id' => $validated['teacher_id'],
            'semester_id' => $validated['semester_id'],
            'title' => $validated['title'],
            'exam_type' => $validated['exam_type'],
            'exam_date' => $validated['exam_date'],
            'total_score' => $validated['total_score'],
            'duration_minutes' => $validated['duration_minutes'] ?? 120,
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'] ?? 'scheduled',
        ]);

        return response()->json([
            'message' => 'Exam created successfully.',
            'data' => $exam->load(['course', 'teacher', 'semester']),
        ], 201);
    }

    public function show(Exam $exam)
    {
        return response()->json([
            'message' => 'Exam retrieved successfully.',
            'data' => $exam->load(['course', 'teacher', 'semester', 'results.student.user']),
        ], 200);
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'exam_type' => 'required|string|in:midterm,final,quiz,assignment',
            'exam_date' => 'required|date',
            'total_score' => 'required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:scheduled,ongoing,completed,cancelled',
        ]);

        $exam->update($validated);

        return response()->json([
            'message' => 'Exam updated successfully.',
            'data' => $exam->fresh()->load(['course', 'teacher', 'semester']),
        ], 200);
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return response()->json([
            'message' => 'Exam deleted successfully.',
        ], 200);
    }
}
