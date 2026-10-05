<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['student.user', 'teacher.user', 'semester']);

        if ($request->has('report_type')) {
            $query->where('report_type', $request->report_type);
        }

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $reports = $query->latest()->get();

        return response()->json([
            'message' => 'Reports retrieved successfully.',
            'data' => $reports,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required|string|max:30',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'student_id' => 'nullable|integer|exists:students,id',
            'teacher_id' => 'nullable|integer|exists:teachers,id',
            'semester_id' => 'nullable|integer|exists:semesters,id',
        ]);

        $report = Report::create([
            'report_type' => $validated['report_type'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'student_id' => $validated['student_id'] ?? null,
            'teacher_id' => $validated['teacher_id'] ?? null,
            'semester_id' => $validated['semester_id'] ?? null,
            'generated_by' => $request->user()?->id,
            'generated_at' => now(),
            'status' => 'generated',
        ]);

        return response()->json([
            'message' => 'Report generated successfully.',
            'data' => $report->load(['student', 'teacher', 'semester']),
        ], 201);
    }

    public function show(Report $report)
    {
        return response()->json([
            'message' => 'Report retrieved successfully.',
            'data' => $report->load(['student.user', 'teacher.user', 'semester']),
        ], 200);
    }

    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:pending,generated,failed',
        ]);

        $report->update($validated);

        return response()->json([
            'message' => 'Report updated successfully.',
            'data' => $report->fresh(),
        ], 200);
    }

    public function destroy(Report $report)
    {
        $report->delete();

        return response()->json([
            'message' => 'Report deleted successfully.',
        ], 200);
    }
}
