<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    public function index(Request $request)
    {
        $query = Prediction::with(['student.user', 'course', 'semester']);

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->has('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        $predictions = $query->latest('prediction_date')->get();

        return response()->json([
            'message' => 'Predictions retrieved successfully.',
            'data' => $predictions,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'course_id' => 'nullable|integer|exists:courses,id',
            'semester_id' => 'required|integer|exists:semesters,id',
            'prediction_type' => 'required|string|max:30',
            'predicted_score' => 'required|numeric|min:0|max:100',
            'confidence_score' => 'nullable|numeric|min:0|max:1.0',
            'model_version' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $prediction = Prediction::create([
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id'] ?? null,
            'semester_id' => $validated['semester_id'],
            'prediction_type' => $validated['prediction_type'],
            'predicted_score' => $validated['predicted_score'],
            'confidence_score' => $validated['confidence_score'] ?? 0.85,
            'prediction_date' => now()->toDateString(),
            'model_version' => $validated['model_version'] ?? 'v1.0.0',
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Prediction generated/saved successfully.',
            'data' => $prediction->load(['student', 'course', 'semester']),
        ], 201);
    }

    public function show(Prediction $prediction)
    {
        return response()->json([
            'message' => 'Prediction retrieved successfully.',
            'data' => $prediction->load(['student.user', 'course', 'semester']),
        ], 200);
    }

    public function update(Request $request, Prediction $prediction)
    {
        $validated = $request->validate([
            'predicted_score' => 'required|numeric|min:0|max:100',
            'confidence_score' => 'nullable|numeric|min:0|max:1.0',
            'notes' => 'nullable|string',
        ]);

        $prediction->update($validated);

        return response()->json([
            'message' => 'Prediction updated successfully.',
            'data' => $prediction->fresh()->load(['student', 'course', 'semester']),
        ], 200);
    }

    public function destroy(Prediction $prediction)
    {
        $prediction->delete();

        return response()->json([
            'message' => 'Prediction deleted successfully.',
        ], 200);
    }
}
