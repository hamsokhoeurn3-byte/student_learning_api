<?php

namespace App\Http\Controllers;

use App\Models\RiskAssessment;
use Illuminate\Http\Request;

class RiskAssessmentController extends Controller
{
    public function index(Request $request)
    {
        $query = RiskAssessment::with(['student.user', 'course', 'semester']);

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->has('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        if ($request->has('risk_level')) {
            $query->where('risk_level', $request->risk_level);
        }

        $assessments = $query->latest('assessment_date')->get();

        return response()->json([
            'message' => 'Risk assessments retrieved successfully.',
            'data' => $assessments,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'course_id' => 'nullable|integer|exists:courses,id',
            'semester_id' => 'required|integer|exists:semesters,id',
            'risk_level' => 'required|string|in:low,medium,high',
            'risk_score' => 'required|numeric|min:0|max:100',
            'risk_factors' => 'nullable|array',
            'status' => 'nullable|string|in:open,monitoring,resolved',
        ]);

        $assessment = RiskAssessment::create([
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id'] ?? null,
            'semester_id' => $validated['semester_id'],
            'risk_level' => $validated['risk_level'],
            'risk_score' => $validated['risk_score'],
            'risk_factors' => isset($validated['risk_factors']) ? json_encode($validated['risk_factors']) : null,
            'assessment_date' => now()->toDateString(),
            'status' => $validated['status'] ?? 'open',
        ]);

        return response()->json([
            'message' => 'Risk assessment created successfully.',
            'data' => $assessment->load(['student', 'course', 'semester']),
        ], 201);
    }

    public function show(RiskAssessment $riskAssessment)
    {
        return response()->json([
            'message' => 'Risk assessment retrieved successfully.',
            'data' => $riskAssessment->load(['student.user', 'course', 'semester']),
        ], 200);
    }

    public function update(Request $request, RiskAssessment $riskAssessment)
    {
        $validated = $request->validate([
            'risk_level' => 'required|string|in:low,medium,high',
            'risk_score' => 'required|numeric|min:0|max:100',
            'status' => 'nullable|string|in:open,monitoring,resolved',
        ]);

        $riskAssessment->update($validated);

        return response()->json([
            'message' => 'Risk assessment updated successfully.',
            'data' => $riskAssessment->fresh()->load(['student', 'course', 'semester']),
        ], 200);
    }

    public function destroy(RiskAssessment $riskAssessment)
    {
        $riskAssessment->delete();

        return response()->json([
            'message' => 'Risk assessment deleted successfully.',
        ], 200);
    }
}
