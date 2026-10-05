<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceDetail;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['course', 'teacher', 'semester']);

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->has('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        if ($request->has('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        $sessions = $query->latest()->get();

        return response()->json([
            'message' => 'Attendance sessions retrieved successfully.',
            'data' => $sessions,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|integer|exists:courses,id',
            'teacher_id' => 'required|integer|exists:teachers,id',
            'semester_id' => 'required|integer|exists:semesters,id',
            'attendance_date' => 'required|date',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'topic' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $attendance = Attendance::create($validated);

        return response()->json([
            'message' => 'Attendance session created successfully.',
            'data' => $attendance->load(['course', 'teacher', 'semester']),
        ], 201);
    }

    public function show(Attendance $attendance)
    {
        return response()->json([
            'message' => 'Attendance session retrieved successfully.',
            'data' => $attendance->load(['course', 'teacher', 'semester', 'details.student.user']),
        ], 200);
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'attendance_date' => 'nullable|date',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
            'topic' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $attendance->update($validated);

        return response()->json([
            'message' => 'Attendance session updated successfully.',
            'data' => $attendance->fresh()->load(['course', 'teacher', 'semester']),
        ], 200);
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return response()->json([
            'message' => 'Attendance session deleted successfully.',
        ], 200);
    }
}
