<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssignmentSubmissionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceDetailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseEnrollmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\GpaRecordController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\LearningAnalyticController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PerformanceRecordController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\QuizAnswerController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizQuestionController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RiskAssessmentController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'loginApi']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // Dashboards
    Route::get('/dashboard/student', [DashboardController::class, 'student']);
    Route::get('/dashboard/teacher', [DashboardController::class, 'teacher']);
    Route::get('/dashboard/admin', [DashboardController::class, 'admin']);

    Route::get('/student/attendance', [DashboardController::class, 'studentAttendance']);
    Route::get('/student/assignments', [DashboardController::class, 'studentAssignments']);

    // Protected Academic Records
    Route::apiResource('grades', GradeController::class);
    Route::apiResource('gpa-records', GpaRecordController::class);
    Route::apiResource('performance-records', PerformanceRecordController::class);
});

/*
|--------------------------------------------------------------------------
| Core System & Learning Analytics Resource APIs
|--------------------------------------------------------------------------
*/
Route::apiResource('departments', DepartmentController::class);
Route::apiResource('academic-years', AcademicYearController::class);
Route::apiResource('semesters', SemesterController::class);
Route::apiResource('classes', ClassRoomController::class);

Route::apiResource('students', StudentController::class);
Route::apiResource('teachers', TeacherController::class);
Route::apiResource('admins', AdminController::class);

Route::apiResource('courses', CourseController::class);
Route::apiResource('course-enrollments', CourseEnrollmentController::class);

Route::apiResource('attendance', AttendanceController::class);
Route::apiResource('attendance-details', AttendanceDetailController::class);

Route::apiResource('assignments', AssignmentController::class);
Route::apiResource('assignment-submissions', AssignmentSubmissionController::class);

Route::apiResource('quizzes', QuizController::class);
Route::apiResource('quiz-questions', QuizQuestionController::class);
Route::apiResource('quiz-attempts', QuizAttemptController::class);
Route::apiResource('quiz-answers', QuizAnswerController::class);

Route::apiResource('exams', ExamController::class);
Route::apiResource('exam-results', ExamResultController::class);

// Note: grades, gpa-records, and performance-records have been moved to the auth:sanctum group
Route::apiResource('learning-analytics', LearningAnalyticController::class);
Route::apiResource('predictions', PredictionController::class);
Route::apiResource('risk-assessments', RiskAssessmentController::class);
Route::apiResource('recommendations', RecommendationController::class);

Route::apiResource('notifications', NotificationController::class);
Route::apiResource('reports', ReportController::class);
