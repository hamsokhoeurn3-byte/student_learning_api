<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentAssignmentController;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\AssignmentAttempt;
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
            $student = Student::where('user_id', Auth::id())->first();

            return view('pages.student.profile.index', [
                'student' => $student,
            ]);
        })->name('student.profile');

        Route::get('/profile/edit', function () {
            $student = Student::where('user_id', Auth::id())->first();

            return view('pages.student.profile.edit', [
                'student' => $student,
            ]);
        })->name('student.profile.edit');



        Route::get('/attendance', function () {
            return view('pages.student.attendance.index');
        })->name('student.attendance');

        Route::get('/assignments', [StudentAssignmentController::class, 'index'])->name('student.assignments');
        Route::get('/assignments/{assignment}/submit', [StudentAssignmentController::class, 'take'])->name('student.assignments.submit');
        Route::post('/assignments/{assignment}/submit', [StudentAssignmentController::class, 'submit'])->name('student.assignments.store');


        // Continue Assignment
        Route::get('/assignments/{assignment}/continue', function ($assignment) {
            return view('pages.student.assignments.continue', [
                'assignment' => $assignment
            ]);
        })->name('student.assignments.continue');


        // View Assignment Result
        Route::get('/assignments/{assignment}/result', [StudentAssignmentController::class, 'result'])->name('student.assignments.result');

        Route::get('/quizzes', function () {
            $student = Student::where('user_id', Auth::id())->first();
            $enrolledCourseIds = $student
                ? DB::table('course_enrollments')->where('student_id', $student->id)->where('status', 'enrolled')->pluck('course_id')
                : collect();
            $quizzes = $enrolledCourseIds->isNotEmpty()
                ? Assignment::with([
                    'course',
                    'questions',
                    'attempts' => fn ($query) => $query
                        ->where('student_id', $student->id)
                        ->orderByDesc('attempt_number'),
                ])
                    ->whereIn('course_id', $enrolledCourseIds)
                    ->where('assignment_type', 'true_false')
                    ->where('status', 'published')
                    ->orderBy('ends_at')
                    ->get()
                : collect();
            $quizAttempts = $quizzes->flatMap(fn (Assignment $quiz) => $quiz->attempts);
            $gradedQuizAttempts = $quizAttempts->filter(fn (AssignmentAttempt $attempt) => $attempt->score !== null);
            $weekStart = now()->startOfWeek();
            $weekEnd = now()->endOfWeek();
            $dueThisWeek = $quizzes->filter(function (Assignment $quiz) use ($weekStart, $weekEnd) {
                $dueAt = $quiz->ends_at ?? $quiz->due_date?->endOfDay();

                return $dueAt && $dueAt->between($weekStart, $weekEnd);
            })->count();

            return view('pages.student.quizzes.index', [
                'quizzes' => $quizzes,
                'availableCount' => $quizzes->count(),
                'completedCount' => $quizzes->filter(fn (Assignment $quiz) => $quiz->attempts->isNotEmpty())->count(),
                'averageScore' => $gradedQuizAttempts->avg('score'),
                'dueThisWeek' => $dueThisWeek,
                'attemptCount' => $quizAttempts->count(),
                'gradedCount' => $gradedQuizAttempts->count(),
                'bestScore' => $gradedQuizAttempts->max('score'),
            ]);
        })->name('student.quizzes');

        Route::get('/search', function (Request $request) {
            $validated = $request->validate([
                'q' => 'required|string|max:100',
            ]);
            $term = trim($validated['q']);
            $student = Student::where('user_id', Auth::id())->first();
            $enrolledCourseIds = $student
                ? $student->courses()->wherePivot('status', 'enrolled')->select('courses.id')
                : collect();
            $courses = $student
                ? $student->courses()
                    ->with('teacher.user')
                    ->wherePivot('status', 'enrolled')
                    ->where(fn ($query) => $query
                        ->where('courses.name', 'like', '%' . $term . '%')
                        ->orWhere('courses.code', 'like', '%' . $term . '%'))
                    ->orderBy('courses.name')
                    ->get()
                : collect();
            $assignments = Assignment::with('course')
                ->whereIn('course_id', $enrolledCourseIds)
                ->where('status', 'published')
                ->where(fn ($query) => $query
                    ->where('title', 'like', '%' . $term . '%')
                    ->orWhere('description', 'like', '%' . $term . '%'))
                ->orderBy('title')
                ->get();

            return view('pages.student.search', compact('term', 'courses', 'assignments'));
        })->name('student.search');

        Route::get('/grades', function () {
            $student = Student::where('user_id', Auth::id())->first();
            $attempts = $student
                ? AssignmentAttempt::with('assignment.course')
                    ->where('student_id', $student->id)
                    ->whereNotNull('submitted_at')
                    ->latest('submitted_at')
                    ->get()
                : collect();
            $gradedAttempts = $attempts->filter(fn (AssignmentAttempt $attempt) => $attempt->score !== null);

            return view('pages.student.grades.index', [
                'gradeAttempts' => $attempts,
                'gradedCount' => $gradedAttempts->count(),
                'pendingCount' => $attempts->count() - $gradedAttempts->count(),
                'averageScore' => $gradedAttempts->avg('score'),
            ]);
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

        $buildTeacherReport = function (): array {
            $teacher = Teacher::where('user_id', Auth::id())->first();
            $courses = $teacher
                ? Course::where('teacher_id', $teacher->id)->orderBy('name')->get()
                : collect();
            $courseIds = $courses->pluck('id');
            $enrollmentCounts = DB::table('course_enrollments')
                ->whereIn('course_id', $courseIds)
                ->where('status', 'enrolled')
                ->selectRaw('course_id, COUNT(*) as enrolled_count')
                ->groupBy('course_id')
                ->pluck('enrolled_count', 'course_id');
            $attendanceCounts = Attendance::query()
                ->whereIn('course_id', $courseIds)
                ->whereIn('status', ['present', 'absent', 'late'])
                ->select('course_id')
                ->selectRaw('COUNT(*) as marked_count')
                ->selectRaw("SUM(CASE WHEN status IN ('present', 'late') THEN 1 ELSE 0 END) as attended_count")
                ->selectRaw("SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent_count")
                ->groupBy('course_id')
                ->get()
                ->keyBy('course_id');
            $assignmentCounts = Assignment::whereIn('course_id', $courseIds)
                ->selectRaw('course_id, COUNT(*) as assignment_count')
                ->groupBy('course_id')
                ->pluck('assignment_count', 'course_id');
            $rows = $courses->map(function (Course $course) use ($enrollmentCounts, $attendanceCounts, $assignmentCounts) {
                $attendance = $attendanceCounts->get($course->id);
                $markedCount = (int) ($attendance?->marked_count ?? 0);
                $attendedCount = (int) ($attendance?->attended_count ?? 0);

                return [
                    'name' => $course->name,
                    'code' => $course->code,
                    'enrolled' => (int) $enrollmentCounts->get($course->id, 0),
                    'attendance_rate' => $markedCount > 0 ? round($attendedCount / $markedCount * 100) . '%' : 'No records',
                    'attended' => $attendedCount,
                    'absent' => (int) ($attendance?->absent_count ?? 0),
                    'assignments' => (int) $assignmentCounts->get($course->id, 0),
                ];
            });
            $totalMarked = $attendanceCounts->sum('marked_count');
            $totalAttended = $attendanceCounts->sum('attended_count');

            return [
                'reportRows' => $rows,
                'reportStats' => [
                    ['Assigned classes', number_format($courses->count()), 'book'],
                    ['Enrolled seats', number_format($enrollmentCounts->sum()), 'people'],
                    ['Attendance rate', $totalMarked > 0 ? round($totalAttended / $totalMarked * 100) . '%' : 'No records', 'calendar-check'],
                    ['Assignments', number_format($assignmentCounts->sum()), 'journal-text'],
                ],
            ];
        };

        Route::get('/dashboard', function () {
            $teacher = Teacher::where('user_id', Auth::id())->first();
            $teacherCourseIds = $teacher ? Course::where('teacher_id', $teacher->id)->pluck('id') : collect();
            $weekStart = now()->startOfWeek()->startOfDay();
            $submissionCounts = AssignmentAttempt::query()
                ->whereIn('assignment_id', Assignment::whereIn('course_id', $teacherCourseIds)->select('id'))
                ->whereBetween('submitted_at', [$weekStart, $weekStart->copy()->addDays(6)->endOfDay()])
                ->selectRaw('DATE(submitted_at) as activity_date, COUNT(*) as total')
                ->groupBy('activity_date')
                ->pluck('total', 'activity_date');
            $submissionsByDay = collect(range(0, 6))->mapWithKeys(function ($offset) use ($weekStart, $submissionCounts) {
                $day = $weekStart->copy()->addDays($offset);

                return [$day->toDateString() => (int) $submissionCounts->get($day->toDateString(), 0)];
            });
            $pendingAttemptsQuery = AssignmentAttempt::query()
                ->with(['assignment.course', 'student.user'])
                ->whereIn('assignment_id', Assignment::whereIn('course_id', $teacherCourseIds)->select('id'))
                ->whereNotNull('submitted_at')
                ->whereNull('score');
            $upcomingAssignments = Assignment::with('course')
                ->whereIn('course_id', $teacherCourseIds)
                ->where('status', 'published')
                ->where(fn ($query) => $query
                    ->whereDate('ends_at', '>=', today())
                    ->orWhere(fn ($query) => $query->whereNull('ends_at')->whereDate('due_date', '>=', today())))
                ->orderByRaw('COALESCE(ends_at, due_date) asc')
                ->limit(5)
                ->get();

            return view('pages.teacher.dashboard', [
                'dashboardStats' => [
                    ['Assigned courses', number_format($teacherCourseIds->count()), 'book'],
                    ['Students', number_format($teacherCourseIds->isEmpty() ? 0 : Student::whereHas('courses', fn ($query) => $query->whereIn('courses.id', $teacherCourseIds)->where('course_enrollments.status', 'enrolled'))->count()), 'people'],
                    ['To grade', number_format((clone $pendingAttemptsQuery)->count()), 'clipboard-check'],
                    ['Active assignments', number_format(Assignment::whereIn('course_id', $teacherCourseIds)->where('status', 'published')->count()), 'journal-text'],
                ],
                'submissionsByDay' => $submissionsByDay,
                'pendingAttempts' => $pendingAttemptsQuery->latest('submitted_at')->limit(5)->get(),
                'upcomingAssignments' => $upcomingAssignments,
            ]);
        })->name('teacher.dashboard');

        Route::get('/students', function (Request $request) {
            $teacher = Teacher::where('user_id', Auth::id())->first();
            $teacherCourseIds = $teacher ? Course::where('teacher_id', $teacher->id)->pluck('id') : collect();
            $search = trim((string) $request->query('search', ''));
            $studentQuery = Student::query()
                ->with(['user', 'courses' => fn ($query) => $query->whereIn('courses.id', $teacherCourseIds)])
                ->whereHas('courses', fn ($query) => $query->whereIn('courses.id', $teacherCourseIds));

            if ($search !== '') {
                $searchTerm = '%' . $search . '%';
                $studentQuery->where(function ($query) use ($searchTerm, $teacherCourseIds) {
                    $query->where('student_code', 'like', $searchTerm)
                        ->orWhere('first_name', 'like', $searchTerm)
                        ->orWhere('last_name', 'like', $searchTerm)
                        ->orWhere('department', 'like', $searchTerm)
                        ->orWhereHas('user', fn ($userQuery) => $userQuery->where('name', 'like', $searchTerm))
                        ->orWhereHas('courses', fn ($courseQuery) => $courseQuery
                            ->whereIn('courses.id', $teacherCourseIds)
                            ->where(fn ($courseDetails) => $courseDetails
                                ->where('courses.name', 'like', $searchTerm)
                                ->orWhere('courses.code', 'like', $searchTerm)));
                });
            }

            $allAssignedStudents = Student::whereHas('courses', fn ($query) => $query->whereIn('courses.id', $teacherCourseIds));
            $managementRows = $studentQuery
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(fn (Student $student) => [
                    $student->user?->name ?? trim($student->first_name . ' ' . $student->last_name),
                    $student->student_id,
                    $student->courses->pluck('code')->join(', '),
                    ucfirst($student->status),
                    $student->id,
                ]);

            return view('pages.teacher.students.index', [
                'managementStats' => [
                    ['Enrolled students', number_format((clone $allAssignedStudents)->count()), 'people'],
                    ['My courses', number_format($teacher ? Course::where('teacher_id', $teacher->id)->count() : 0), 'book'],
                    ['Needs attention', number_format((clone $allAssignedStudents)->whereIn('status', ['suspended', 'inactive'])->count()), 'clock'],
                ],
                'managementRows' => $managementRows,
                'managementCount' => $managementRows->total(),
                'search' => $search,
            ]);
        })->name('teacher.students');
        Route::get('/students/{student}', function (Student $student) {
            $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();
            $student = Student::with([
                'user',
                'courses' => fn ($query) => $query
                    ->where('courses.teacher_id', $teacher->id)
                    ->where('course_enrollments.status', 'enrolled'),
            ])
                ->whereKey($student->id)
                ->whereHas('courses', fn ($query) => $query
                    ->where('courses.teacher_id', $teacher->id)
                    ->where('course_enrollments.status', 'enrolled'))
                ->firstOrFail();

            return view('pages.teacher.students.show', compact('student'));
        })->name('teacher.students.show');
        Route::get('/attendance', function (Request $request) {
            $teacher = Teacher::where('user_id', Auth::id())->first();
            $courses = $teacher
                ? Course::where('teacher_id', $teacher->id)->orderBy('name')->get()
                : collect();
            $requestedCourseId = $request->query('course_id');
            $selectedCourse = $requestedCourseId
                ? $courses->firstWhere('id', (int) $requestedCourseId)
                : $courses->first();

            abort_if($requestedCourseId && !$selectedCourse, 404);

            $attendanceDate = $request->validate([
                'date' => 'nullable|date_format:Y-m-d',
            ])['date'] ?? now()->toDateString();
            $classDate = \Carbon\Carbon::createFromFormat('!Y-m-d', $attendanceDate);
            $canMarkAttendance = false;
            $attendanceAvailabilityMessage = null;

            if ($selectedCourse) {
                if (!$selectedCourse->day_of_week || !$selectedCourse->start_time) {
                    $attendanceAvailabilityMessage = 'Attendance is unavailable until the class schedule has a day and start time.';
                } elseif (strcasecmp($selectedCourse->day_of_week, $classDate->format('l')) !== 0) {
                    $attendanceAvailabilityMessage = 'Attendance is only available on the scheduled class day.';
                } elseif ($classDate->gt(now()->startOfDay())) {
                    $attendanceAvailabilityMessage = 'Attendance opens on ' . $classDate->format('F j') . ' at ' . substr($selectedCourse->start_time, 0, 5) . '.';
                } elseif ($classDate->isToday() && now()->format('H:i:s') < substr($selectedCourse->start_time, 0, 8)) {
                    $attendanceAvailabilityMessage = 'Attendance opens at ' . substr($selectedCourse->start_time, 0, 5) . '.';
                } else {
                    $canMarkAttendance = true;
                }
            }

            $students = $selectedCourse
                ? $selectedCourse->students()
                    ->wherePivot('status', 'enrolled')
                    ->with('user')
                    ->orderBy('last_name')
                    ->orderBy('first_name')
                    ->get()
                : collect();
            $attendanceByStudent = $selectedCourse
                ? Attendance::where('course_id', $selectedCourse->id)
                    ->whereDate('attendance_date', $attendanceDate)
                    ->get()
                    ->keyBy('student_id')
                : collect();

            return view('pages.teacher.attendance.index', compact(
                'courses',
                'selectedCourse',
                'attendanceDate',
                'canMarkAttendance',
                'attendanceAvailabilityMessage',
                'students',
                'attendanceByStudent',
            ));
        })->name('teacher.attendance');
        Route::post('/attendance', function (Request $request) {
            $validated = $request->validate([
                'course_id' => 'required|integer|exists:courses,id',
                'attendance_date' => 'required|date_format:Y-m-d',
                'attendance' => 'required|array|min:1',
                'attendance.*' => 'required|in:present,absent,late,excused',
            ]);

            $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();
            $course = Course::where('teacher_id', $teacher->id)->findOrFail($validated['course_id']);
            $classDate = \Carbon\Carbon::createFromFormat('!Y-m-d', $validated['attendance_date']);

            abort_if(
                !$course->day_of_week
                || strcasecmp($course->day_of_week, $classDate->format('l')) !== 0
                || !$course->start_time
                || $classDate->isFuture(),
                403
            );
            if ($classDate->isToday()) {
                abort_if(now()->format('H:i:s') < substr($course->start_time, 0, 8), 403);
            }

            $enrolledStudentIds = $course->students()
                ->wherePivot('status', 'enrolled')
                ->pluck('students.id')
                ->map(fn ($studentId) => (int) $studentId)
                ->all();
            $submittedStudentIds = array_map('intval', array_keys($validated['attendance']));

            abort_if(array_diff($submittedStudentIds, $enrolledStudentIds), 403);

            DB::transaction(function () use ($validated, $course) {
                foreach ($validated['attendance'] as $studentId => $status) {
                    Attendance::updateOrCreate(
                        [
                            'course_id' => $course->id,
                            'student_id' => $studentId,
                            'attendance_date' => $validated['attendance_date'],
                        ],
                        [
                            'status' => $status,
                            'marked_by' => Auth::id(),
                        ]
                    );
                }
            });

            return redirect()->route('teacher.attendance', [
                'course_id' => $course->id,
                'date' => $validated['attendance_date'],
            ])->with('status', 'Attendance saved successfully.');
        })->name('teacher.attendance.store');
        Route::get('/assignments', function () {
            $teacher = Teacher::where('user_id', Auth::id())->first();
            $courseIds = $teacher ? Course::where('teacher_id', $teacher->id)->pluck('id') : collect();
            $managementRows = Assignment::with('course')
                ->whereIn('course_id', $courseIds)
                ->latest()
                ->paginate(10)
                ->through(fn (Assignment $assignment) => [
                    $assignment->title,
                    $assignment->course?->code ?? 'Course unavailable',
                    $assignment->due_date?->format('M d, Y')
                        ? ($assignment->starts_at && $assignment->ends_at
                            ? $assignment->starts_at->format('M d, Y H:i') . ' - ' . $assignment->ends_at->format('M d, Y H:i')
                            : $assignment->due_date->format('M d, Y'))
                        : 'No due date',
                    ucfirst($assignment->status),
                    $assignment->id,
                        (int) $assignment->created_by === (int) Auth::id(),
                ]);

            return view('pages.teacher.assignments.index', [
                'managementStats' => [
                    ['My Assignments', number_format($managementRows->total()), 'journal-text'],
                    ['Due this week', number_format(Assignment::whereIn('course_id', $courseIds)->whereBetween('due_date', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()])->count()), 'clock'],
                    ['Published', number_format(Assignment::whereIn('course_id', $courseIds)->where('status', 'published')->count()), 'journal-check'],
                ],
                'managementRows' => $managementRows,
                'managementCount' => $managementRows->total(),
                'courses' => $teacher ? Course::where('teacher_id', $teacher->id)->orderBy('name')->get(['id', 'name', 'code']) : collect(),
                'isQuizPage' => false,
            ]);
        })->name('teacher.assignments');
        Route::post('/assignments', function (Request $request) {
            $validated = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:2000',
                'starts_at' => 'required|date_format:Y-m-d\\TH:i',
                'ends_at' => 'required|date_format:Y-m-d\\TH:i|after:starts_at',
                'assignment_type' => 'required|in:file_upload,true_false',
                'allow_retakes' => 'nullable|boolean',
                'max_attempts' => 'required_if:allow_retakes,1|nullable|integer|min:2|max:20',
                'questions' => 'required_if:assignment_type,true_false|array|min:1',
                'questions.*.prompt' => 'required_with:questions|string|max:2000',
                'questions.*.correct_answer' => 'required_with:questions|in:true,false',
                'content_type' => 'nullable|in:assignment,quiz',
                'status' => 'required|in:draft,published,closed',
            ]);
            $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();
            $course = Course::where('teacher_id', $teacher->id)->findOrFail($validated['course_id']);
            $startsAt = \Carbon\Carbon::createFromFormat('Y-m-d\\TH:i', $validated['starts_at']);
            $endsAt = \Carbon\Carbon::createFromFormat('Y-m-d\\TH:i', $validated['ends_at']);

            DB::transaction(function () use ($validated, $course, $startsAt, $endsAt) {
                $allowRetakes = (bool) ($validated['allow_retakes'] ?? false);
                $assignment = Assignment::create([
                    'course_id' => $course->id,
                    'created_by' => Auth::id(),
                    'title' => $validated['title'],
                    'description' => $validated['description'] ?? null,
                    'due_date' => $endsAt->toDateString(),
                    'starts_at' => $startsAt,
                    'ends_at' => $endsAt,
                    'assignment_type' => $validated['assignment_type'],
                    'allow_retakes' => $allowRetakes,
                    'max_attempts' => $allowRetakes ? (int) $validated['max_attempts'] : 1,
                    'status' => $validated['status'],
                ]);

                if ($assignment->assignment_type === 'true_false') {
                    foreach ($validated['questions'] as $position => $question) {
                        $assignment->questions()->create([
                            'prompt' => $question['prompt'],
                            'correct_answer' => $question['correct_answer'] === 'true',
                            'position' => $position,
                        ]);
                    }
                }
            });

            $isQuiz = ($validated['content_type'] ?? 'assignment') === 'quiz';

            return redirect()->route($isQuiz ? 'teacher.quizzes' : 'teacher.assignments')
                ->with('status', $isQuiz ? 'Quiz created successfully.' : 'Assignment created successfully.');
        })->name('teacher.assignments.store');
        $findAssignedTeacherAssignment = function (Assignment $assignment): Assignment {
            $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

            return Assignment::with(['course', 'creator'])
                ->whereKey($assignment->id)
                ->whereHas('course', fn ($query) => $query->where('teacher_id', $teacher->id))
                ->firstOrFail();
        };
        $findOwnedTeacherAssignment = function (Assignment $assignment) use ($findAssignedTeacherAssignment): Assignment {
            $assignment = $findAssignedTeacherAssignment($assignment);
            abort_unless((int) $assignment->created_by === (int) Auth::id(), 404);

            return $assignment;
        };
        Route::get('/assignments/{assignment}', function (Assignment $assignment) use ($findAssignedTeacherAssignment) {
            $assignment = $findAssignedTeacherAssignment($assignment);
            $assignment->load(['questions', 'attempts.student.user']);

            return view('pages.teacher.assignments.show', compact('assignment'));
        })->name('teacher.assignments.show');
        Route::get('/assignments/{assignment}/attempts/{attempt}/download', function (Assignment $assignment, AssignmentAttempt $attempt) use ($findAssignedTeacherAssignment) {
            $assignment = $findAssignedTeacherAssignment($assignment);
            $attempt = AssignmentAttempt::where('assignment_id', $assignment->id)->findOrFail($attempt->id);
            abort_unless($attempt->file_path, 404);
            $stream = Storage::disk('local')->readStream($attempt->file_path);
            abort_unless(is_resource($stream), 404);

            return response()->streamDownload(function () use ($stream) {
                fpassthru($stream);
                fclose($stream);
            }, basename($attempt->file_name ?? basename($attempt->file_path)), [
                'Content-Type' => 'application/octet-stream',
            ]);
        })->name('teacher.assignments.attempts.download');
        Route::get('/assignments/{assignment}/edit', function (Assignment $assignment) use ($findOwnedTeacherAssignment) {
            $assignment = $findOwnedTeacherAssignment($assignment);
            $assignment->load('questions');
            $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();
            $courses = Course::where('teacher_id', $teacher->id)->orderBy('name')->get(['id', 'name', 'code']);

            return view('pages.teacher.assignments.edit', compact('assignment', 'courses'));
        })->name('teacher.assignments.edit');
        Route::put('/assignments/{assignment}', function (Request $request, Assignment $assignment) use ($findOwnedTeacherAssignment) {
            $assignment = $findOwnedTeacherAssignment($assignment);
            $validated = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:2000',
                'starts_at' => 'required|date_format:Y-m-d\\TH:i',
                'ends_at' => 'required|date_format:Y-m-d\\TH:i|after:starts_at',
                'assignment_type' => 'required|in:file_upload,true_false',
                'allow_retakes' => 'nullable|boolean',
                'max_attempts' => 'required_if:allow_retakes,1|nullable|integer|min:2|max:20',
                'questions' => 'required_if:assignment_type,true_false|array|min:1',
                'questions.*.prompt' => 'required_with:questions|string|max:2000',
                'questions.*.correct_answer' => 'required_with:questions|in:true,false',
                'status' => 'required|in:draft,published,closed',
            ]);
            $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();
            $course = Course::where('teacher_id', $teacher->id)->findOrFail($validated['course_id']);
            $startsAt = \Carbon\Carbon::createFromFormat('Y-m-d\\TH:i', $validated['starts_at']);
            $endsAt = \Carbon\Carbon::createFromFormat('Y-m-d\\TH:i', $validated['ends_at']);

            $allowRetakes = (bool) ($validated['allow_retakes'] ?? false);
            DB::transaction(function () use ($assignment, $course, $validated, $startsAt, $endsAt, $allowRetakes) {
                $assignment->update([
                    'course_id' => $course->id,
                    'title' => $validated['title'],
                    'description' => $validated['description'] ?? null,
                    'starts_at' => $startsAt,
                    'ends_at' => $endsAt,
                    'due_date' => $endsAt->toDateString(),
                    'assignment_type' => $validated['assignment_type'],
                    'allow_retakes' => $allowRetakes,
                    'max_attempts' => $allowRetakes ? (int) $validated['max_attempts'] : 1,
                    'status' => $validated['status'],
                ]);
                $assignment->questions()->delete();
                if ($assignment->assignment_type === 'true_false') {
                    foreach ($validated['questions'] as $position => $question) {
                        $assignment->questions()->create([
                            'prompt' => $question['prompt'],
                            'correct_answer' => $question['correct_answer'] === 'true',
                            'position' => $position,
                        ]);
                    }
                }
            });

            return redirect()->route('teacher.assignments.show', $assignment)->with('status', 'Assignment updated successfully.');
        })->name('teacher.assignments.update');
        Route::delete('/assignments/{assignment}', function (Assignment $assignment) use ($findOwnedTeacherAssignment) {
            $assignment = $findOwnedTeacherAssignment($assignment);
            $isQuiz = $assignment->assignment_type === 'true_false';
            $assignment->delete();

            return redirect()->route($isQuiz ? 'teacher.quizzes' : 'teacher.assignments')
                ->with('status', $isQuiz ? 'Quiz deleted successfully.' : 'Assignment deleted successfully.');
        })->name('teacher.assignments.destroy');
        Route::get('/quizzes', function () {
            $teacher = Teacher::where('user_id', Auth::id())->first();
            $courseIds = $teacher ? Course::where('teacher_id', $teacher->id)->pluck('id') : collect();
            $quizzes = Assignment::with('course')
                ->whereIn('course_id', $courseIds)
                ->where('assignment_type', 'true_false')
                ->latest()
                ->paginate(10);
            $managementRows = $quizzes->through(fn (Assignment $quiz) => [
                $quiz->title,
                $quiz->course?->code ?? 'Course unavailable',
                $quiz->due_date?->format('M d, Y')
                    ? ($quiz->starts_at && $quiz->ends_at
                        ? $quiz->starts_at->format('M d, Y H:i') . ' - ' . $quiz->ends_at->format('M d, Y H:i')
                        : $quiz->due_date->format('M d, Y'))
                    : 'No due date',
                ucfirst($quiz->status),
                $quiz->id,
                (int) $quiz->created_by === (int) Auth::id(),
            ]);

            return view('pages.teacher.assignments.index', [
                'managementStats' => [
                    ['My quizzes', number_format($quizzes->total()), 'patch-question'],
                    ['Due this week', number_format(Assignment::whereIn('course_id', $courseIds)->where('assignment_type', 'true_false')->whereBetween('due_date', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()])->count()), 'clock'],
                    ['Published', number_format(Assignment::whereIn('course_id', $courseIds)->where('assignment_type', 'true_false')->where('status', 'published')->count()), 'journal-check'],
                ],
                'managementRows' => $managementRows,
                'managementCount' => $quizzes->total(),
                'courses' => $teacher ? Course::where('teacher_id', $teacher->id)->orderBy('name')->get(['id', 'name', 'code']) : collect(),
                'isQuizPage' => true,
            ]);
        })->name('teacher.quizzes');
        Route::get('/grades', function () {
            $teacher = Teacher::where('user_id', Auth::id())->first();
            $courseIds = $teacher ? Course::where('teacher_id', $teacher->id)->select('id') : collect();
            $attemptQuery = AssignmentAttempt::whereHas('assignment', fn ($query) => $query->whereIn('course_id', $courseIds))
                ->whereNotNull('submitted_at');
            $attempts = (clone $attemptQuery)
                ->with(['assignment.course', 'student.user', 'grader'])
                ->latest('submitted_at')
                ->paginate(20);
            $gradedCount = (clone $attemptQuery)->whereNotNull('score')->count();

            return view('pages.teacher.grades.index', [
                'attempts' => $attempts,
                'submittedCount' => (clone $attemptQuery)->count(),
                'gradedCount' => $gradedCount,
                'pendingCount' => (clone $attemptQuery)->whereNull('score')->count(),
            ]);
        })->name('teacher.grades');
        Route::put('/grades/{attempt}', function (Request $request, AssignmentAttempt $attempt) {
            $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();
            $attempt = AssignmentAttempt::whereKey($attempt->id)
                ->whereHas('assignment.course', fn ($query) => $query->where('teacher_id', $teacher->id))
                ->whereNotNull('submitted_at')
                ->firstOrFail();
            $validated = $request->validate([
                'score' => 'required|numeric|min:0|max:100',
            ]);

            $attempt->update([
                'score' => $validated['score'],
                'graded_by' => Auth::id(),
                'graded_at' => now(),
            ]);

            return redirect()->route('teacher.grades')->with('status', 'Score saved successfully.');
        })->name('teacher.grades.update');
        Route::get('/courses', function () {
            $teacher = Teacher::where('user_id', Auth::id())->first();
            $courses = $teacher
                ? Course::where('teacher_id', $teacher->id)->latest()->paginate(10)
                : Course::whereRaw('1 = 0')->paginate(10);
            $managementRows = $courses->through(fn (Course $course) => [
                $course->name,
                $course->code,
                trim(implode(' · ', array_filter([
                    $course->day_of_week,
                    $course->start_time && $course->end_time ? substr($course->start_time, 0, 5) . ' - ' . substr($course->end_time, 0, 5) : null,
                    $course->room,
                ]))) ?: 'Schedule not set',
                ucfirst($course->status),
                $course->id,
            ]);

            return view('pages.teacher.courses.index', [
                'managementStats' => [
                    ['Assigned Classes', number_format($courses->total()), 'book'],
                    ['Enrolled students', number_format($teacher ? Student::whereHas('courses', fn ($query) => $query->whereIn('courses.id', Course::where('teacher_id', $teacher->id)->select('id')))->count() : 0), 'people'],
                    ['Active classes', number_format($teacher ? Course::where('teacher_id', $teacher->id)->where('status', 'active')->count() : 0), 'graph-up-arrow'],
                ],
                'managementRows' => $managementRows,
                'managementCount' => $courses->total(),
            ]);
        })->name('teacher.courses');
        Route::get('/courses/{course}', function (Course $course) {
            $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();
            $course = Course::with(['teacher.user', 'assignments'])
                ->where('teacher_id', $teacher->id)
                ->findOrFail($course->id);

            return view('pages.teacher.courses.show', compact('course'));
        })->name('teacher.courses.show');
        Route::get('/calendar', function (Request $request) {
            $validated = $request->validate([
                'month' => 'nullable|date_format:Y-m',
            ]);
            $month = isset($validated['month'])
                ? \Carbon\Carbon::createFromFormat('!Y-m', $validated['month'])
                : now()->startOfMonth();
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();
            $calendarStart = $monthStart->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
            $calendarEnd = $monthEnd->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);
            $teacher = Teacher::where('user_id', Auth::id())->first();
            $courses = $teacher
                ? Course::where('teacher_id', $teacher->id)->orderBy('name')->get()
                : collect();
            $courseIds = $courses->pluck('id');
            $assignments = Assignment::with('course')
                ->whereIn('course_id', $courseIds)
                ->whereNotNull('due_date')
                ->whereBetween('due_date', [$calendarStart->toDateString(), $calendarEnd->toDateString()])
                ->get();
            $eventsByDate = [];

            foreach ($assignments as $assignment) {
                $dateKey = $assignment->due_date->format('Y-m-d');
                $eventsByDate[$dateKey][] = [
                    'type' => 'Assignment due',
                    'title' => $assignment->title,
                    'course' => $assignment->course?->code,
                    'detail' => implode(' · ', array_filter([
                        $assignment->ends_at ? 'Due ' . $assignment->ends_at->format('H:i') : null,
                        $assignment->course?->name,
                    ])),
                    'time' => $assignment->ends_at?->format('H:i') ?? '23:59',
                ];
            }

            $calendarDays = [];
            $classEventCount = 0;
            $assignmentEventCount = $assignments->filter(fn (Assignment $assignment) => $assignment->due_date->betweenIncluded($monthStart, $monthEnd))->count();
            $currentDay = $calendarStart->copy();

            while ($currentDay->lte($calendarEnd)) {
                $dateKey = $currentDay->format('Y-m-d');
                $dayEvents = $eventsByDate[$dateKey] ?? [];

                foreach ($courses as $course) {
                    if (!$course->day_of_week || strcasecmp($course->day_of_week, $currentDay->format('l')) !== 0) {
                        continue;
                    }

                    $scheduleDetails = array_filter([
                        $course->start_time ? substr($course->start_time, 0, 5) : null,
                        $course->end_time ? substr($course->end_time, 0, 5) : null,
                        $course->room,
                    ]);
                    $dayEvents[] = [
                        'type' => 'Class',
                        'title' => $course->name,
                        'course' => $course->code,
                        'detail' => implode(' - ', $scheduleDetails),
                        'time' => $course->start_time ? substr($course->start_time, 0, 5) : '00:00',
                        'canTakeAttendance' => $course->start_time !== null && (
                            $currentDay->lt(now()->startOfDay())
                            || ($currentDay->isToday() && now()->format('H:i:s') >= substr($course->start_time, 0, 8))
                        ),
                        'attendanceUrl' => route('teacher.attendance', [
                            'course_id' => $course->id,
                            'date' => $dateKey,
                        ]),
                        'attendanceOpensAt' => $course->start_time ? substr($course->start_time, 0, 5) : null,
                    ];

                    if ($currentDay->betweenIncluded($monthStart, $monthEnd)) {
                        $classEventCount++;
                    }
                }

                usort($dayEvents, fn (array $left, array $right) => strcmp($left['time'], $right['time']));
                $calendarDays[] = [
                    'date' => $currentDay->copy(),
                    'events' => $dayEvents,
                    'isCurrentMonth' => $currentDay->month === $monthStart->month,
                ];
                $currentDay->addDay();
            }

            return view('pages.teacher.calendar.index', [
                'calendarDays' => $calendarDays,
                'monthLabel' => $monthStart->format('F Y'),
                'monthValue' => $monthStart->format('Y-m'),
                'previousMonth' => $monthStart->copy()->subMonth()->format('Y-m'),
                'nextMonth' => $monthStart->copy()->addMonth()->format('Y-m'),
                'classEventCount' => $classEventCount,
                'assignmentEventCount' => $assignmentEventCount,
            ]);
        })->name('teacher.calendar');
        Route::get('/reports', function () use ($buildTeacherReport) {
            return view('pages.teacher.reports.index', $buildTeacherReport());
        })->name('teacher.reports');
        Route::get('/reports/export', function () use ($buildTeacherReport) {
            $reportRows = $buildTeacherReport()['reportRows'];

            return response()->streamDownload(function () use ($reportRows) {
                $output = fopen('php://output', 'w');
                fputcsv($output, ['Class', 'Code', 'Enrolled students', 'Attendance rate', 'Present or late', 'Absent', 'Assignments']);
                foreach ($reportRows as $row) {
                    fputcsv($output, array_values($row));
                }
                fclose($output);
            }, 'teacher-class-report-' . now()->format('Y-m-d') . '.csv', ['Content-Type' => 'text/csv']);
        })->name('teacher.reports.export');
        Route::get('/reports/export/pdf', function () use ($buildTeacherReport) {
            return Pdf::loadView('pages.teacher.reports.pdf', $buildTeacherReport() + [
                'teacherName' => Auth::user()->name,
                'generatedAt' => now()->format('F j, Y H:i'),
            ])->setPaper('a4', 'landscape')
                ->download('teacher-class-report-' . now()->format('Y-m-d') . '.pdf');
        })->name('teacher.reports.export-pdf');
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
                'student_id' => 'required|string|max:50|unique:students,student_code',
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
                'teacher_id' => 'required|string|max:50|unique:teachers,teacher_code',
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

        Route::get('/assign-class', function () {
            return view('pages.admin.courses.assign-class', [
                'courses' => Course::orderBy('name')->get(),
                'teachers' => Teacher::with('user')->orderBy('first_name')->get(),
                'students' => Student::with('user')->orderBy('last_name')->orderBy('first_name')->get(),
            ]);
        })->name('admin.assign-class');

        Route::post('/assign-class', function (Request $request) {
            $validated = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'teacher_id' => 'nullable|exists:teachers,id',
                'student_ids' => 'nullable|array',
                'student_ids.*' => 'integer|exists:students,id',
                'day_of_week' => 'nullable|string|max:20',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i',
                'academic_year' => 'nullable|string|max:20',
                'semester' => 'nullable|string|max:50',
                'room' => 'nullable|string|max:100',
            ]);

            $course = Course::findOrFail($validated['course_id']);
            $course->update([
                'teacher_id' => $validated['teacher_id'] ?? null,
                'day_of_week' => $validated['day_of_week'] ?? null,
                'start_time' => $validated['start_time'] ?? null,
                'end_time' => $validated['end_time'] ?? null,
                'academic_year' => $validated['academic_year'] ?? null,
                'semester' => $validated['semester'] ?? null,
                'room' => $validated['room'] ?? null,
            ]);

            DB::table('classes')->updateOrInsert(
                ['course_id' => $course->id],
                [
                    'teacher_id' => $course->teacher_id,
                    'name' => $course->name,
                    'code' => $course->code,
                    'day_of_week' => $course->day_of_week,
                    'start_time' => $course->start_time,
                    'end_time' => $course->end_time,
                    'room' => $course->room,
                    'status' => $course->status,
                    'updated_at' => now(),
                ]
            );

            if (!empty($validated['student_ids'])) {
                foreach ($validated['student_ids'] as $studentId) {
                    $course->students()->syncWithoutDetaching([
                        $studentId => [
                            'status' => 'enrolled',
                        ],
                    ]);
                }
            }

            return redirect()->route('admin.assign-class')->with('status', 'Class assigned successfully.');
        })->name('admin.assign-class.store');

        Route::post('/courses', function (Request $request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:courses,code',
                'department' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:2000',
                'credits' => 'nullable|integer|min:1|max:30',
                'teacher_id' => 'nullable|exists:teachers,id',
                'student_ids' => 'nullable|array',
                'student_ids.*' => 'integer|exists:students,id',
                'academic_year' => 'nullable|string|max:20',
                'semester' => 'nullable|string|max:50',
                'day_of_week' => 'nullable|string|max:20',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i',
                'room' => 'nullable|string|max:100',
                'status' => 'required|in:active,inactive',
            ]);

            $course = Course::create($validated);

            DB::table('classes')->updateOrInsert(
                ['course_id' => $course->id],
                [
                    'teacher_id' => $validated['teacher_id'] ?? null,
                    'name' => $course->name,
                    'code' => $course->code,
                    'day_of_week' => $validated['day_of_week'] ?? null,
                    'start_time' => $validated['start_time'] ?? null,
                    'end_time' => $validated['end_time'] ?? null,
                    'room' => $validated['room'] ?? null,
                    'status' => $course->status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            if (! empty($validated['teacher_id'])) {
                $course->update(['teacher_id' => $validated['teacher_id']]);
            }

            if (! empty($validated['student_ids'])) {
                foreach ($validated['student_ids'] as $studentId) {
                    $course->students()->syncWithoutDetaching([
                        $studentId => [
                            'status' => 'enrolled',
                        ],
                    ]);
                }
            }

            return redirect()->route('admin.assign-class')->with('status', 'Class created successfully.');
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

        Route::get('/reports/export/pdf', function () {
            $reportRows = [
                ['Students', Student::count()],
                ['Teachers', Teacher::count()],
                ['Courses', Course::count()],
                ['Assignments', Assignment::count()],
            ];

            return Pdf::loadView('pages.admin.reports.pdf', [
                'reportRows' => $reportRows,
                'generatedAt' => now()->format('F j, Y H:i'),
            ])->download('slas-report-' . now()->format('Y-m-d') . '.pdf');
        })->name('admin.reports.export-pdf');

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

