<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AuthController;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

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
            return view('pages.student.dashboard', [
                'studentProfile' => Student::where('user_id', Auth::id())->first(),
            ]);
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
            $student = Student::where('user_id', Auth::id())->first();
            $courses = $student
                ? $student->courses()->with('teacher.user')->wherePivot('status', 'enrolled')->orderBy('code')->get()
                : collect();
            $assignments = $student
                ? Assignment::with('course')->whereIn('course_id', $courses->pluck('id'))->where('status', 'published')->orderBy('due_date')->get()
                : collect();

            return view('pages.student.courses.index', compact('courses', 'assignments'));
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
            $weekStart = now()->startOfWeek()->startOfDay();
            $activityByDay = User::query()
                ->whereBetween('created_at', [$weekStart, $weekStart->copy()->addDays(6)->endOfDay()])
                ->selectRaw('DATE(created_at) as activity_date, COUNT(*) as total')
                ->groupBy('activity_date')
                ->pluck('total', 'activity_date')
                ->all();

            return view('pages.teacher.dashboard', [
                'dashboardStats' => [
                    ['Students', number_format(Student::count()), 'people'],
                    ['Pending grading', 'N/A', 'clipboard-check'],
                    ['Active assignments', 'N/A', 'journal-text'],
                    ['Average attendance', 'N/A', 'calendar-check'],
                ],
                'activityByDay' => $activityByDay,
            ]);
        })->name('teacher.dashboard');

        Route::get('/students', function () {
            $teacher = Teacher::where('user_id', Auth::id())->first();
            $teacherCourseIds = $teacher ? Course::where('teacher_id', $teacher->id)->pluck('id') : collect();
            $managementRows = Student::query()
                ->with(['user', 'courses' => fn ($query) => $query->whereIn('courses.id', $teacherCourseIds)])
                ->whereHas('courses', fn ($query) => $query->whereIn('courses.id', $teacherCourseIds))
                ->latest()
                ->paginate(10)
                ->through(fn (Student $student) => [
                    $student->user?->name ?? trim($student->first_name . ' ' . $student->last_name),
                    $student->student_id,
                    $student->courses->pluck('code')->join(', '),
                    ucfirst($student->status),
                ]);

            return view('pages.teacher.students.index', [
                'managementStats' => [
                    ['Enrolled students', number_format($managementRows->total()), 'people'],
                    ['My courses', number_format($teacher ? Course::where('teacher_id', $teacher->id)->count() : 0), 'book'],
                    ['Needs attention', number_format($teacherCourseIds->isEmpty() ? 0 : Student::whereHas('courses', fn ($query) => $query->whereIn('courses.id', $teacherCourseIds))->whereIn('status', ['suspended', 'inactive'])->count()), 'clock'],
                ],
                'managementRows' => $managementRows,
                'managementCount' => $managementRows->total(),
            ]);
        })->name('teacher.students');
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
            $weekStart = now()->startOfWeek()->startOfDay();
            $activityByDay = User::query()
                ->whereBetween('created_at', [$weekStart, $weekStart->copy()->addDays(6)->endOfDay()])
                ->selectRaw('DATE(created_at) as activity_date, COUNT(*) as total')
                ->groupBy('activity_date')
                ->pluck('total', 'activity_date')
                ->all();

            return view('pages.admin.dashboard', [
                'dashboardStats' => [
                    ['Total students', number_format(Student::count()), 'mortarboard'],
                    ['Teachers', number_format(Teacher::count()), 'person-workspace'],
                    ['Active courses', number_format(Course::where('status', 'active')->count()), 'book'],
                    ['Completion rate', 'N/A', 'graph-up-arrow'],
                ],
                'activityByDay' => $activityByDay,
            ]);
        })->name('admin.dashboard');

        Route::get('/students', function () {
            $managementRows = Student::with('user')->latest()->paginate(10)
                ->through(fn (Student $student) => [
                    $student->user?->name ?? trim($student->first_name . ' ' . $student->last_name),
                    $student->student_id,
                    $student->department ?? 'Not set',
                    ucfirst($student->status),
                    $student->id,
                ]);
            $studentCount = $managementRows->total();

            return view('pages.admin.students.index', [
                'managementStats' => [
                    ['Total Students', number_format($studentCount), 'collection'],
                    ['Needs attention', number_format(Student::whereIn('status', ['suspended', 'inactive'])->count()), 'clock'],
                    ['Attendance', 'N/A', 'graph-up-arrow'],
                ],
                'managementRows' => $managementRows,
                'managementCount' => $studentCount,
            ]);
        })->name('admin.students');

        Route::post('/students', function (Request $request) {
            $validated = $request->validate([
                'student_id' => 'required|string|max:50|unique:students,student_id',
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:Male,Female',
                'department' => 'nullable|string|max:255',
                'major' => 'nullable|string|max:255',
                'academic_year' => 'nullable|string|max:20',
                'year_level' => 'nullable|string|max:255',
                'semester' => 'nullable|string|max:50',
                'status' => 'required|in:enrolled,graduated,suspended,inactive',
            ]);

            DB::transaction(function () use ($validated) {
                $user = User::create([
                    'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'student',
                ]);

                Student::create($validated + ['user_id' => $user->id]);
            });

            return redirect()->route('admin.students')->with('status', 'Student and login account created successfully.');
        })->name('admin.students.store');

        Route::get('/students/{student}', [\App\Http\Controllers\AdminPeopleController::class, 'showStudent'])->name('admin.students.show');
        Route::get('/students/{student}/edit', [\App\Http\Controllers\AdminPeopleController::class, 'editStudent'])->name('admin.students.edit');
        Route::put('/students/{student}', [\App\Http\Controllers\AdminPeopleController::class, 'updateStudent'])->name('admin.students.update');
        Route::delete('/students/{student}', [\App\Http\Controllers\AdminPeopleController::class, 'destroyStudent'])->name('admin.students.destroy');

        Route::get('/teachers', function () {
            $managementRows = Teacher::with('user')->latest()->paginate(10)
                ->through(fn (Teacher $teacher) => [
                    $teacher->user?->name ?? trim($teacher->first_name . ' ' . $teacher->last_name),
                    $teacher->teacher_id,
                    $teacher->department ?? $teacher->specialization ?? 'Not set',
                    ucfirst($teacher->status),
                    $teacher->id,
                ]);
            $teacherCount = $managementRows->total();

            return view('pages.admin.teachers.index', [
                'managementStats' => [
                    ['Total Teachers', number_format($teacherCount), 'collection'],
                    ['Needs attention', number_format(Teacher::where('status', '!=', 'active')->count()), 'clock'],
                    ['Active teachers', number_format(Teacher::where('status', 'active')->count()), 'graph-up-arrow'],
                ],
                'managementRows' => $managementRows,
                'managementCount' => $teacherCount,
            ]);
        })->name('admin.teachers');

        Route::post('/teachers', function (Request $request) {
            $validated = $request->validate([
                'teacher_id' => 'required|string|max:50|unique:teachers,teacher_id',
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'date_of_birth' => 'nullable|date',
                'gender' => 'nullable|in:Male,Female',
                'department' => 'nullable|string|max:255',
                'position' => 'nullable|string|max:255',
                'specialization' => 'nullable|string|max:255',
                'status' => 'required|string|max:50',
            ]);

            DB::transaction(function () use ($validated) {
                $user = User::create([
                    'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'teacher',
                ]);

                Teacher::create($validated + ['user_id' => $user->id]);
            });

            return redirect()->route('admin.teachers')->with('status', 'Teacher and login account created successfully.');
        })->name('admin.teachers.store');

        Route::get('/teachers/{teacher}', [\App\Http\Controllers\AdminPeopleController::class, 'showTeacher'])->name('admin.teachers.show');
        Route::get('/teachers/{teacher}/edit', [\App\Http\Controllers\AdminPeopleController::class, 'editTeacher'])->name('admin.teachers.edit');
        Route::put('/teachers/{teacher}', [\App\Http\Controllers\AdminPeopleController::class, 'updateTeacher'])->name('admin.teachers.update');
        Route::delete('/teachers/{teacher}', [\App\Http\Controllers\AdminPeopleController::class, 'destroyTeacher'])->name('admin.teachers.destroy');

        Route::get('/courses', function () {
            $managementRows = Course::latest()->paginate(10)
                ->through(fn (Course $course) => [
                    $course->name,
                    $course->code,
                    trim(($course->department ?? 'Department not set') . ($course->credits ? ' · ' . $course->credits . ' credits' : '')),
                    ucfirst($course->status),
                    $course->id,
                ]);
            $courseCount = $managementRows->total();

            return view('pages.admin.courses.index', [
                'managementStats' => [
                    ['Total Courses', number_format($courseCount), 'collection'],
                    ['Needs attention', number_format(Course::where('status', 'inactive')->count()), 'clock'],
                    ['Active courses', number_format(Course::where('status', 'active')->count()), 'graph-up-arrow'],
                ],
                'managementRows' => $managementRows,
                'managementCount' => $courseCount,
                'teachers' => Teacher::with('user')->orderBy('first_name')->get(),
            ]);
        })->name('admin.courses');

        Route::post('/courses', function (Request $request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:courses,code',
                'department' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:2000',
                'credits' => 'nullable|integer|min:1|max:30',
                'teacher_id' => 'nullable|exists:teachers,id',
                'academic_year' => 'nullable|string|max:20',
                'semester' => 'nullable|string|max:50',
                'status' => 'required|in:active,inactive',
            ]);

            Course::create($validated);

            return redirect()->route('admin.courses')->with('status', 'Course created successfully.');
        })->name('admin.courses.store');

        Route::get('/courses/{course}', [\App\Http\Controllers\AdminCourseController::class, 'show'])->name('admin.courses.show');
        Route::get('/courses/{course}/edit', [\App\Http\Controllers\AdminCourseController::class, 'edit'])->name('admin.courses.edit');
        Route::put('/courses/{course}', [\App\Http\Controllers\AdminCourseController::class, 'update'])->name('admin.courses.update');
        Route::delete('/courses/{course}', [\App\Http\Controllers\AdminCourseController::class, 'destroy'])->name('admin.courses.destroy');
        Route::put('/courses/{course}/teacher', [\App\Http\Controllers\AdminCourseController::class, 'assignTeacher'])->name('admin.courses.teacher.update');
            Route::post('/courses/{course}/students', [\App\Http\Controllers\AdminCourseController::class, 'enrollStudents'])->name('admin.courses.students.store');
            Route::delete('/courses/{course}/students/{student}', [\App\Http\Controllers\AdminCourseController::class, 'removeStudent'])->name('admin.courses.students.destroy');

        Route::get('/assignments', function () {
            $managementRows = Assignment::with('course')->latest()->paginate(10)
                ->through(fn (Assignment $assignment) => [
                    $assignment->title,
                    $assignment->course?->code ?? 'Course unavailable',
                    $assignment->due_date?->format('M d, Y') ?? 'No due date',
                    ucfirst($assignment->status),
                    $assignment->id,
                ]);
            $assignmentCount = $managementRows->total();
            $courses = Course::orderBy('name')->get(['id', 'name', 'code']);

            return view('pages.admin.assignments.index', [
                'managementStats' => [
                    ['Total Assignments', number_format($assignmentCount), 'collection'],
                    ['Due this week', number_format(Assignment::whereBetween('due_date', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()])->count()), 'clock'],
                    ['Published', number_format(Assignment::where('status', 'published')->count()), 'journal-check'],
                ],
                'managementRows' => $managementRows,
                'managementCount' => $assignmentCount,
                'courses' => $courses,
            ]);
        })->name('admin.assignments');

        Route::post('/assignments', function (Request $request) {
            $validated = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:2000',
                'due_date' => 'nullable|date',
                'status' => 'required|in:draft,published,closed',
            ]);

            Assignment::create($validated + ['created_by' => Auth::id()]);

            return redirect()->route('admin.assignments')->with('status', 'Assignment created successfully.');
        })->name('admin.assignments.store');

        Route::get('/assignments/{assignment}', [\App\Http\Controllers\AdminAssignmentController::class, 'show'])->name('admin.assignments.show');
        Route::get('/assignments/{assignment}/edit', [\App\Http\Controllers\AdminAssignmentController::class, 'edit'])->name('admin.assignments.edit');
        Route::put('/assignments/{assignment}', [\App\Http\Controllers\AdminAssignmentController::class, 'update'])->name('admin.assignments.update');
        Route::delete('/assignments/{assignment}', [\App\Http\Controllers\AdminAssignmentController::class, 'destroy'])->name('admin.assignments.destroy');

        Route::get('/reports/export', function () {
            $reportRows = [
                ['Students', Student::count()],
                ['Teachers', Teacher::count()],
                ['Courses', Course::count()],
                ['Assignments', Assignment::count()],
            ];

            return response()->streamDownload(function () use ($reportRows) {
                $output = fopen('php://output', 'w');
                fputcsv($output, ['Record type', 'Count']);
                foreach ($reportRows as $row) {
                    fputcsv($output, $row);
                }
                fclose($output);
            }, 'slas-report-' . now()->format('Y-m-d') . '.csv', ['Content-Type' => 'text/csv']);
        })->name('admin.reports.export');

        Route::get('/reports', function () {
            return view('pages.admin.reports.index', [
                'managementStats' => [
                    ['Students', number_format(Student::count()), 'people'],
                    ['Teachers', number_format(Teacher::count()), 'person-workspace'],
                    ['Courses', number_format(Course::count()), 'book'],
                    ['Assignments', number_format(Assignment::count()), 'journal-text'],
                ],
                'managementRows' => [],
                'managementCount' => 0,
            ]);
        })->name('admin.reports');
        Route::view('/settings', 'pages.admin.settings.index')->name('admin.settings');
        Route::post('/settings/profile', [AuthController::class, 'updateProfile'])
            ->name('admin.profile.update');
    });
