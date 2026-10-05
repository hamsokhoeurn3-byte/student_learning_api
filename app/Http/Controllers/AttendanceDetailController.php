<?php

namespace App\Http\Controllers;

use App\Models\AttendanceDetail;
use Illuminate\Http\Request;

class AttendanceDetailController extends Controller
{
    public function index(Request $request)
    {
        $query = AttendanceDetail::with(['attendance.course', 'student.user']);

        if ($request->has('attendance_id')) {
            $query->where('attendance_id', $request->attendance_id);
        }

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $details = $query->latest()->get();

        return response()->json([
            'message' => 'Attendance details retrieved successfully.',
            'data' => $details,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'attendance_id' => 'required|integer|exists:attendance,id',
            'student_id' => 'required|integer|exists:students,id',
            'status' => 'required|string|in:present,absent,late,excused',
            'remarks' => 'nullable|string|max:255',
        ]);

        $detail = AttendanceDetail::updateOrCreate(
            [
                'attendance_id' => $validated['attendance_id'],
                'student_id' => $validated['student_id'],
            ],
            [
                'status' => $validated['status'],
                'remarks' => $validated['remarks'] ?? null,
            ]
        );

        return response()->json([
            'message' => 'Attendance detail saved successfully.',
            'data' => $detail->load(['attendance', 'student']),
        ], 201);
    }

    public function show(AttendanceDetail $attendanceDetail)
    {
        return response()->json([
            'message' => 'Attendance detail retrieved successfully.',
            'data' => $attendanceDetail->load(['attendance.course', 'student.user']),
        ], 200);
    }

    public function update(Request $request, AttendanceDetail $attendanceDetail)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:present,absent,late,excused',
            'remarks' => 'nullable|string|max:255',
        ]);

        $attendanceDetail->update($validated);

        return response()->json([
            'message' => 'Attendance detail updated successfully.',
            'data' => $attendanceDetail->fresh()->load(['attendance', 'student']),
        ], 200);
    }

    public function destroy(AttendanceDetail $attendanceDetail)
    {
        $attendanceDetail->delete();

        return response()->json([
            'message' => 'Attendance detail deleted successfully.',
        ], 200);
    }
}
