<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Department;
use App\Models\Grade;
use App\Models\LearningAnalytic;
use App\Models\Notification;
use App\Models\Prediction;
use App\Models\Quiz;
use App\Models\Recommendation;
use App\Models\RiskAssessment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\GpaRecord;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function student(Request $request)
    {
        $user = $request->user();
        $student = $user?->student ?? Student::first();

        if (! $student) {
            return response()->json(['message' => 'Student profile not found.'], 444);
        }

        $enrollments = CourseEnrollment::where('student_id', $student->id)
            ->with(['course.teacher.user', 'semester'])
            ->get();

        $analytics = LearningAnalytic::where('student_id', $student->id)->latest('calculated_at')->first();

        $predictions = Prediction::where('student_id', $student->id)->with('course')->latest()->take(5)->get();

        $riskAssessment = RiskAssessment::where('student_id', $student->id)->latest('assessment_date')->first();

        $recommendations = Recommendation::where('student_id', $student->id)
            ->where('status', 'pending')
            ->take(5)
            ->get();

        $notifications = Notification::where('user_id', $user?->id ?? $student->user_id)
            ->latest()
            ->take(5)
            ->get();

        $recentGrades = Grade::where('student_id', $student->id)->with('course')->latest()->take(5)->get();

        $gpaRecord = GpaRecord::where('student_id', $student->id)->latest('id')->first();

        // Chart Data for Learning Analytics
        $allAnalytics = LearningAnalytic::where('student_id', $student->id)->orderBy('period_start')->take(6)->get();
        $chartData = [];
        $chartLabels = [];
        foreach ($allAnalytics as $analytic) {
            $chartLabels[] = \Carbon\Carbon::parse($analytic->period_start)->format('M');
            $chartData[] = $analytic->overall_performance ?? 0;
        }

        // Chart Data for Predictions
        $predictionHistory = Prediction::where('student_id', $student->id)->orderBy('prediction_date')->take(6)->get();
        $predChartLabels = [];
        $predChartData = [];
        foreach ($predictionHistory as $pred) {
            $predChartLabels[] = \Carbon\Carbon::parse($pred->prediction_date)->format('M');
            $predChartData[] = $pred->predicted_score ?? 0;
        }

        return response()->json([
            'message' => 'Student dashboard retrieved successfully.',
            'data' => [
                'student' => $student->load(['department', 'classRoom', 'user']),
                'enrollments' => $enrollments,
                'analytics' => $analytics,
                'predictions' => $predictions,
                'risk_assessment' => $riskAssessment,
                'recommendations' => $recommendations,
                'notifications' => $notifications,
                'recent_grades' => $recentGrades,
                'gpa' => $gpaRecord ? $gpaRecord->gpa : null,
                'gpa_record' => $gpaRecord,
                'chart_data' => $chartData,
                'chart_labels' => $chartLabels,
                'prediction_chart_data' => $predChartData,
                'prediction_chart_labels' => $predChartLabels,
            ],
        ], 200);
    }

    public function studentAttendance(Request $request)
    {
        $user = $request->user();
        $student = $user?->student;

        if (! $student) {
            return response()->json(['message' => 'Student profile not found.'], 404);
        }

        $details = \App\Models\AttendanceDetail::with(['attendance.course', 'attendance.teacher.user'])
            ->where('student_id', $student->id)
            ->latest()
            ->get();

        // Calculate attendance summary
        $totalClasses = $details->count();
        $presentCount = $details->where('status', 'present')->count();
        $absentCount = $details->where('status', 'absent')->count();
        $lateCount = $details->where('status', 'late')->count();
        $excusedCount = $details->where('status', 'excused')->count();

        return response()->json([
            'message' => 'Student attendance retrieved successfully.',
            'data' => [
                'details' => $details,
                'summary' => [
                    'total' => $totalClasses,
                    'present' => $presentCount,
                    'absent' => $absentCount,
                    'late' => $lateCount,
                    'excused' => $excusedCount,
                    'percentage' => $totalClasses > 0 ? round(($presentCount / $totalClasses) * 100, 2) : 0
                ]
            ],
        ], 200);
    }

    public function studentAssignments(Request $request)
    {
        $user = $request->user();
        $student = $user?->student;

        if (! $student) {
            return response()->json(['message' => 'Student profile not found.'], 404);
        }

        $assignments = \App\Models\Assignment::with([
            'course',
            'submissions' => function ($query) use ($student) {
                $query->where('student_id', $student->id);
            },
            'attempts' => function ($query) use ($student) {
                $query->where('student_id', $student->id)->orderByDesc('attempt_number');
            }
        ])
            ->where('status', 'published')
            ->whereHas('course.students', function ($query) use ($student) {
                $query->where('students.id', $student->id)
                      ->where('course_enrollments.status', 'enrolled');
            })
            ->orderBy('due_date')
            ->get();

        return response()->json([
            'message' => 'Student assignments retrieved successfully.',
            'data' => $assignments,
        ], 200);
    }

    public function teacher(Request $request)
    {
        $user = $request->user();
        $teacher = $user?->teacher ?? Teacher::first();

        if (! $teacher) {
            return response()->json(['message' => 'Teacher profile not found.'], 404);
        }

        $courses = Course::where('teacher_id', $teacher->id)->withCount('enrollments')->get();
        $courseIds = $courses->pluck('id');

        $activeAssignments = Assignment::whereIn('course_id', $courseIds)->latest()->take(5)->get();
        $activeQuizzes = Quiz::whereIn('course_id', $courseIds)->latest()->take(5)->get();

        $highRiskStudents = RiskAssessment::whereIn('course_id', $courseIds)
            ->whereIn('risk_level', ['medium', 'high'])
            ->with(['student.user', 'course'])
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'message' => 'Teacher dashboard retrieved successfully.',
            'data' => [
                'teacher' => $teacher->load(['department', 'user']),
                'courses' => $courses,
                'total_students' => CourseEnrollment::whereIn('course_id', $courseIds)->distinct('student_id')->count('student_id'),
                'active_assignments' => $activeAssignments,
                'active_quizzes' => $activeQuizzes,
                'at_risk_students' => $highRiskStudents,
            ],
        ], 200);
    }

    public function admin()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalCourses = Course::count();
        $totalDepartments = Department::count();

        $riskDistribution = [
            'low' => RiskAssessment::where('risk_level', 'low')->count(),
            'medium' => RiskAssessment::where('risk_level', 'medium')->count(),
            'high' => RiskAssessment::where('risk_level', 'high')->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();

        return response()->json([
            'message' => 'Admin dashboard retrieved successfully.',
            'data' => [
                'total_students' => $totalStudents,
                'total_teachers' => $totalTeachers,
                'total_courses' => $totalCourses,
                'total_departments' => $totalDepartments,
                'risk_distribution' => $riskDistribution,
                'recent_users' => $recentUsers,
            ],
        ], 200);
    }
}
