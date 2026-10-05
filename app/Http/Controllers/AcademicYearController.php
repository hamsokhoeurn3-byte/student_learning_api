<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AcademicYearController extends Controller
{
    public function index()
    {
        $years = AcademicYear::with('semesters')->latest()->get();

        return response()->json([
            'message' => 'Academic years retrieved successfully.',
            'data' => $years,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:academic_years,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'nullable|string|in:active,inactive,completed',
        ]);

        $academicYear = AcademicYear::create([
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'] ?? 'inactive',
        ]);

        return response()->json([
            'message' => 'Academic year created successfully.',
            'data' => $academicYear,
        ], 201);
    }

    public function show(AcademicYear $academicYear)
    {
        return response()->json([
            'message' => 'Academic year retrieved successfully.',
            'data' => $academicYear->load(['semesters', 'classes']),
        ], 200);
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('academic_years', 'name')->ignore($academicYear->id)],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'nullable|string|in:active,inactive,completed',
        ]);

        $academicYear->update($validated);

        return response()->json([
            'message' => 'Academic year updated successfully.',
            'data' => $academicYear->fresh(),
        ], 200);
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();

        return response()->json([
            'message' => 'Academic year deleted successfully.',
        ], 200);
    }
}
