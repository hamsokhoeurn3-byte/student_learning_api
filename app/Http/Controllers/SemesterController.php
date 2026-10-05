<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::with('academicYear')->latest()->get();

        return response()->json([
            'message' => 'Semesters retrieved successfully.',
            'data' => $semesters,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|integer|exists:academic_years,id',
            'name' => 'required|string|max:100',
            'semester_number' => 'required|integer|min:1|max:10',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'nullable|string|in:active,upcoming,completed,inactive',
        ]);

        $semester = Semester::create([
            'academic_year_id' => $validated['academic_year_id'],
            'name' => $validated['name'],
            'semester_number' => $validated['semester_number'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'] ?? 'upcoming',
        ]);

        return response()->json([
            'message' => 'Semester created successfully.',
            'data' => $semester->load('academicYear'),
        ], 201);
    }

    public function show(Semester $semester)
    {
        return response()->json([
            'message' => 'Semester retrieved successfully.',
            'data' => $semester->load('academicYear'),
        ], 200);
    }

    public function update(Request $request, Semester $semester)
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|integer|exists:academic_years,id',
            'name' => 'required|string|max:100',
            'semester_number' => 'required|integer|min:1|max:10',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'nullable|string|in:active,upcoming,completed,inactive',
        ]);

        $semester->update($validated);

        return response()->json([
            'message' => 'Semester updated successfully.',
            'data' => $semester->fresh()->load('academicYear'),
        ], 200);
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();

        return response()->json([
            'message' => 'Semester deleted successfully.',
        ], 200);
    }
}
