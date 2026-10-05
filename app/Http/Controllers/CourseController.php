<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['department', 'teacher'])->latest()->get();

        return response()->json([
            'message' => 'Courses retrieved successfully.',
            'data' => $courses,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|integer|exists:departments,id',
            'teacher_id' => 'nullable|integer|exists:teachers,id',
            'course_code' => 'required|string|max:50|unique:courses,course_code',
            'course_name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'credit' => 'required|numeric|min:0.5|max:10',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $course = Course::create([
            'department_id' => $validated['department_id'],
            'teacher_id' => $validated['teacher_id'] ?? null,
            'course_code' => strtoupper($validated['course_code']),
            'course_name' => $validated['course_name'],
            'description' => $validated['description'] ?? null,
            'credit' => $validated['credit'],
            'status' => $validated['status'] ?? 'active',
        ]);

        return response()->json([
            'message' => 'Course created successfully.',
            'data' => $course->load(['department', 'teacher']),
        ], 201);
    }

    public function show(Course $course)
    {
        return response()->json([
            'message' => 'Course retrieved successfully.',
            'data' => $course->load(['department', 'teacher', 'enrollments.student']),
        ], 200);
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'department_id' => 'required|integer|exists:departments,id',
            'teacher_id' => 'nullable|integer|exists:teachers,id',
            'course_code' => ['required', 'string', 'max:50', Rule::unique('courses', 'course_code')->ignore($course->id)],
            'course_name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'credit' => 'required|numeric|min:0.5|max:10',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $course->update([
            'department_id' => $validated['department_id'],
            'teacher_id' => $validated['teacher_id'] ?? $course->teacher_id,
            'course_code' => strtoupper($validated['course_code']),
            'course_name' => $validated['course_name'],
            'description' => $validated['description'] ?? $course->description,
            'credit' => $validated['credit'],
            'status' => $validated['status'] ?? $course->status,
        ]);

        return response()->json([
            'message' => 'Course updated successfully.',
            'data' => $course->fresh()->load(['department', 'teacher']),
        ], 200);
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'message' => 'Course deleted successfully.',
        ], 200);
    }
}
