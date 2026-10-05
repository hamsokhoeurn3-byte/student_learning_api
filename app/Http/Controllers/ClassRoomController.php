<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassRoomController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::with(['department', 'academicYear'])->latest()->get();

        return response()->json([
            'message' => 'Classes retrieved successfully.',
            'data' => $classes,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|integer|exists:departments,id',
            'academic_year_id' => 'required|integer|exists:academic_years,id',
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:classes,code',
            'year_level' => 'required|integer|min:1|max:10',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $classRoom = ClassRoom::create([
            'department_id' => $validated['department_id'],
            'academic_year_id' => $validated['academic_year_id'],
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'year_level' => $validated['year_level'],
            'status' => $validated['status'] ?? 'active',
        ]);

        return response()->json([
            'message' => 'Class created successfully.',
            'data' => $classRoom->load(['department', 'academicYear']),
        ], 201);
    }

    public function show(ClassRoom $classRoom)
    {
        return response()->json([
            'message' => 'Class retrieved successfully.',
            'data' => $classRoom->load(['department', 'academicYear', 'students']),
        ], 200);
    }

    public function update(Request $request, ClassRoom $classRoom)
    {
        $validated = $request->validate([
            'department_id' => 'required|integer|exists:departments,id',
            'academic_year_id' => 'required|integer|exists:academic_years,id',
            'name' => 'required|string|max:100',
            'code' => ['required', 'string', 'max:50', Rule::unique('classes', 'code')->ignore($classRoom->id)],
            'year_level' => 'required|integer|min:1|max:10',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $classRoom->update([
            'department_id' => $validated['department_id'],
            'academic_year_id' => $validated['academic_year_id'],
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'year_level' => $validated['year_level'],
            'status' => $validated['status'] ?? $classRoom->status,
        ]);

        return response()->json([
            'message' => 'Class updated successfully.',
            'data' => $classRoom->fresh()->load(['department', 'academicYear']),
        ], 200);
    }

    public function destroy(ClassRoom $classRoom)
    {
        $classRoom->delete();

        return response()->json([
            'message' => 'Class deleted successfully.',
        ], 200);
    }
}
