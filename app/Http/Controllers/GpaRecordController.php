<?php

namespace App\Http\Controllers;

use App\Models\GpaRecord;
use Illuminate\Http\Request;

class GpaRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = GpaRecord::with(['student.user', 'semester']);

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        $records = $query->latest()->get();

        return response()->json([
            'message' => 'GPA records retrieved successfully.',
            'data' => $records,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'semester_id' => 'required|integer|exists:semesters,id',
            'gpa' => 'required|numeric|min:0|max:4.0',
            'total_credits' => 'required|numeric|min:0',
            'earned_credits' => 'required|numeric|min:0',
            'academic_standing' => 'nullable|string|max:50',
        ]);

        $record = GpaRecord::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'semester_id' => $validated['semester_id'],
            ],
            $validated
        );

        return response()->json([
            'message' => 'GPA record saved successfully.',
            'data' => $record->load(['student', 'semester']),
        ], 201);
    }

    public function show(GpaRecord $gpaRecord)
    {
        return response()->json([
            'message' => 'GPA record retrieved successfully.',
            'data' => $gpaRecord->load(['student.user', 'semester']),
        ], 200);
    }

    public function update(Request $request, GpaRecord $gpaRecord)
    {
        $validated = $request->validate([
            'gpa' => 'required|numeric|min:0|max:4.0',
            'total_credits' => 'required|numeric|min:0',
            'earned_credits' => 'required|numeric|min:0',
            'academic_standing' => 'nullable|string|max:50',
        ]);

        $gpaRecord->update($validated);

        return response()->json([
            'message' => 'GPA record updated successfully.',
            'data' => $gpaRecord->fresh()->load(['student', 'semester']),
        ], 200);
    }

    public function destroy(GpaRecord $gpaRecord)
    {
        $gpaRecord->delete();

        return response()->json([
            'message' => 'GPA record deleted successfully.',
        ], 200);
    }
}
