<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Student
|--------------------------------------------------------------------------
*/

Route::prefix('student')
    ->middleware('auth')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pages.student.dashboard');
        })->name('student.dashboard');

        Route::get('/profile', function () {
            return view('pages.student.profile.index');
        })->name('student.profile');
        Route::get('/student/profile/edit', function () {
            return view('pages.student.profile.edit');
        })->name('student.profile.edit');



        Route::get('/attendance', function () {
            return view('pages.student.attendance.index');
        })->name('student.attendance');

        Route::get('/assignments', function () {
            return view('pages.student.assignments.index');
        })->name('student.assignments');
        // Submit Assignment
        Route::get('/assignments/{assignment}/submit', function ($assignment) {
            return view('pages.student.assignments.submit', [
                'assignment' => $assignment
            ]);
        })->name('student.assignments.submit');


        // Continue Assignment
        Route::get('/assignments/{assignment}/continue', function ($assignment) {
            return view('pages.student.assignments.continue', [
                'assignment' => $assignment
            ]);
        })->name('student.assignments.continue');


        // View Assignment Result
        Route::get('/assignments/{assignment}/result', function ($assignment) {
            return view('pages.student.assignments.result', [
                'assignment' => $assignment
            ]);
        })->name('student.assignments.result');

        Route::get('/quizzes', function () {
            return view('pages.student.quizzes.index');
        })->name('student.quizzes');

        Route::get('/grades', function () {
            return view('pages.student.grades.index');
        })->name('student.grades');

        Route::get('/analytics', function () {
            return view('pages.student.analytics.index');
        })->name('student.analytics');

        Route::get('/courses', function () {
            return view('pages.student.courses.index');
        })->name('student.courses');

        Route::get('/calendar', function () {
            return view('pages.student.calendar.index');
        })->name('student.calendar');

        Route::get('/notifications', function () {
            return view('pages.student.notifications.index');
        })->name('student.notifications');

        Route::get('/reports', function () {
            return view('pages.student.reports.index');
        })->name('student.reports');
    });


/*
|--------------------------------------------------------------------------
| Teacher
|--------------------------------------------------------------------------
*/

Route::prefix('teacher')
    ->middleware('auth')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pages.teacher.dashboard');
        })->name('teacher.dashboard');
    });


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware('auth')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pages.admin.dashboard');
        })->name('admin.dashboard');
    });