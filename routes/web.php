<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::view('/', 'pages.auth.login')->name('home');

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
    ->middleware(['auth', 'role:student'])
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

        Route::view('/settings', 'pages.student.settings.index')->name('student.settings');
        Route::post('/settings/profile', [AuthController::class, 'updateProfile'])
            ->name('student.profile.update');
    });


/*
|--------------------------------------------------------------------------
| Teacher
|--------------------------------------------------------------------------
*/

Route::prefix('teacher')
    ->middleware(['auth', 'role:teacher'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pages.teacher.dashboard');
        })->name('teacher.dashboard');

        Route::view('/students', 'pages.teacher.students.index')->name('teacher.students');
        Route::view('/attendance', 'pages.teacher.attendance.index')->name('teacher.attendance');
        Route::view('/assignments', 'pages.teacher.assignments.index')->name('teacher.assignments');
        Route::view('/quizzes', 'pages.teacher.quizzes.index')->name('teacher.quizzes');
        Route::view('/grades', 'pages.teacher.grades.index')->name('teacher.grades');
        Route::view('/courses', 'pages.teacher.courses.index')->name('teacher.courses');
        Route::view('/calendar', 'pages.teacher.calendar.index')->name('teacher.calendar');
        Route::view('/reports', 'pages.teacher.reports.index')->name('teacher.reports');
        Route::view('/settings', 'pages.teacher.settings.index')->name('teacher.settings');
        Route::post('/settings/profile', [AuthController::class, 'updateProfile'])
            ->name('teacher.profile.update');
    });


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pages.admin.dashboard');
        })->name('admin.dashboard');

        Route::view('/students', 'pages.admin.students.index')->name('admin.students');
        Route::view('/teachers', 'pages.admin.teachers.index')->name('admin.teachers');
        Route::view('/courses', 'pages.admin.courses.index')->name('admin.courses');
        Route::view('/assignments', 'pages.admin.assignments.index')->name('admin.assignments');
        Route::view('/reports', 'pages.admin.reports.index')->name('admin.reports');
        Route::view('/settings', 'pages.admin.settings.index')->name('admin.settings');
        Route::post('/settings/profile', [AuthController::class, 'updateProfile'])
            ->name('admin.profile.update');
    });
