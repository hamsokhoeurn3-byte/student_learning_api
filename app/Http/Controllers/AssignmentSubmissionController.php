<?php

namespace App\Http\Controllers;

use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;

class AssignmentSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = AssignmentSubmission::with(['assignment.course', 'student.user']);

        if ($request->has('assignment_id')) {
            $query->where('assignment_id', $request->assignment_id);
        }

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $submissions = $query->latest()->get();

        return response()->json([
            'message' => 'Assignment submissions retrieved successfully.',
            'data' => $submissions,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|integer|exists:assignments,id',
            'student_id' => 'required|integer|exists:students,id',
            'file_path' => 'nullable|string',
            'submission_file' => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg|max:10240',
        ]);

        $filePath = $validated['file_path'] ?? null;

        if ($request->hasFile('submission_file')) {
            $filePath = $request->file('submission_file')->store('submissions', 'public');
        }

        $submission = AssignmentSubmission::updateOrCreate(
            [
                'assignment_id' => $validated['assignment_id'],
                'student_id' => $validated['student_id'],
            ],
            [
                'submitted_at' => now(),
                'file_path' => $filePath,
                'status' => 'submitted',
            ]
        );

        return response()->json([
            'message' => 'Assignment submitted successfully.',
            'data' => $submission->load(['assignment', 'student']),
        ], 201);
    }

    public function show(AssignmentSubmission $assignmentSubmission)
    {
        return response()->json([
            'message' => 'Assignment submission retrieved successfully.',
            'data' => $assignmentSubmission->load(['assignment.course', 'student.user']),
        ], 200);
    }

    public function update(Request $request, AssignmentSubmission $assignmentSubmission)
    {
        $validated = $request->validate([
            'score' => 'nullable|numeric|min:0',
            'feedback' => 'nullable|string',
            'status' => 'nullable|string|in:submitted,graded,returned,late',
        ]);

        $assignmentSubmission->update($validated);

        return response()->json([
            'message' => 'Assignment submission updated successfully.',
            'data' => $assignmentSubmission->fresh()->load(['assignment', 'student']),
        ], 200);
    }

    public function destroy(AssignmentSubmission $assignmentSubmission)
    {
        $assignmentSubmission->delete();

        return response()->json([
            'message' => 'Assignment submission deleted successfully.',
        ], 200);
    }
}
