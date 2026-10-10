<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentAttempt;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\GpaRecord;
use App\Models\Grade;
use App\Models\Notification;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Builds real, database-backed data for the student portal pages that were
 * previously showing hardcoded demo content (attendance, analytics, calendar,
 * notifications, reports) and enriches the dashboard.
 */
class StudentPortalController extends Controller
{
    private function currentStudent(): ?Student
    {
        return Student::where('user_id', Auth::id())->first();
    }

    private function enrolledCourseIds(?Student $student): \Illuminate\Support\Collection
    {
        if (! $student) {
            return collect();
        }

        return $student->courses()
            ->wherePivot('status', 'enrolled')
            ->pluck('courses.id');
    }

    /**
     * Dashboard: real profile facts, subject performance from grades, and a
     * recent-activity feed built from the student's own submissions.
     */
    public function dashboard(): View
    {
        $student = $this->currentStudent();
        $courseIds = $this->enrolledCourseIds($student);

        $grades = $student
            ? Grade::with('course')->where('student_id', $student->id)->get()
            : collect();

        $subjectPerformance = $grades
            ->filter(fn (Grade $grade) => $grade->course && $grade->total_score !== null)
            ->map(fn (Grade $grade) => [
                'name' => $grade->course->name,
                'score' => (int) round((float) $grade->total_score),
            ])
            ->sortByDesc('score')
            ->values();

        $recentAttempts = $student
            ? AssignmentAttempt::with('assignment.course')
                ->where('student_id', $student->id)
                ->whereNotNull('submitted_at')
                ->latest('submitted_at')
                ->limit(6)
                ->get()
            : collect();

        $attendanceSummary = $this->attendanceSummary($student);

        return view('pages.student.dashboard', [
            'studentProfile' => $student,
            'subjectPerformance' => $subjectPerformance,
            'recentAttempts' => $recentAttempts,
            'enrolledCourseCount' => $courseIds->count(),
            'attendanceSummary' => $attendanceSummary,
            'gpaSummary' => $this->gpaSummary($student),
        ]);
    }

    /**
     * Attendance: real records for the logged-in student.
     */
    public function attendance(): View
    {
        $student = $this->currentStudent();

        $records = $student
            ? Attendance::with('course')
                ->where('student_id', $student->id)
                ->orderByDesc('attendance_date')
                ->limit(50)
                ->get()
            : collect();

        $summary = $this->attendanceSummary($student);

        // Per-subject attendance rate.
        $bySubject = $student
            ? Attendance::with('course')
                ->where('student_id', $student->id)
                ->get()
                ->groupBy(fn (Attendance $record) => $record->course?->name ?? 'Unknown')
                ->map(function ($rows, $subject) {
                    $total = $rows->count();
                    $attended = $rows->filter(fn (Attendance $r) => in_array($r->status, ['present', 'late'], true))->count();

                    return [
                        'subject' => $subject,
                        'score' => $total > 0 ? (int) round($attended / $total * 100) : 0,
                    ];
                })
                ->sortByDesc('score')
                ->values()
            : collect();

        // Weekly attendance trend (last 4 weeks with records).
        $weeklyTrend = $student
            ? Attendance::where('student_id', $student->id)
                ->orderBy('attendance_date')
                ->get()
                ->groupBy(fn (Attendance $r) => $r->attendance_date?->format('Y-\WW'))
                ->map(function ($rows) {
                    $total = $rows->count();
                    $attended = $rows->filter(fn (Attendance $r) => in_array($r->status, ['present', 'late'], true))->count();

                    return $total > 0 ? (int) round($attended / $total * 100) : 0;
                })
                ->take(-4)
                ->values()
            : collect();

        return view('pages.student.attendance.index', [
            'records' => $records,
            'summary' => $summary,
            'bySubject' => $bySubject,
            'weeklyTrend' => $weeklyTrend,
        ]);
    }

    /**
     * Analytics: GPA progression, performance breakdown, subject performance,
     * and computed insights — all from real grade/GPA/attendance data.
     */
    public function analytics(): View
    {
        $student = $this->currentStudent();

        $gpaRecords = $student
            ? GpaRecord::with('semester')->where('student_id', $student->id)->orderBy('id')->get()
            : collect();

        $grades = $student
            ? Grade::with('course')->where('student_id', $student->id)->get()
            : collect();

        $attendanceSummary = $this->attendanceSummary($student);

        // Assignment / quiz completion from real attempts.
        $courseIds = $this->enrolledCourseIds($student);
        $published = Assignment::whereIn('course_id', $courseIds)
            ->where('status', 'published')
            ->get();
        $attemptCounts = $student
            ? AssignmentAttempt::where('student_id', $student->id)
                ->whereNotNull('submitted_at')
                ->get()
            : collect();
        $gradedAttempts = $attemptCounts->filter(fn (AssignmentAttempt $a) => $a->score !== null);

        $overallGpa = $gpaRecords->isNotEmpty()
            ? round((float) $gpaRecords->last()->gpa, 2)
            : ($grades->isNotEmpty() ? round((float) $grades->avg('grade_point'), 2) : null);

        $gpaProgression = $gpaRecords->map(fn (GpaRecord $record) => [
            'label' => $record->semester?->name ?? ('Semester ' . $record->semester_id),
            'gpa' => round((float) $record->gpa, 2),
        ])->values();

        // Weighted category averages from the grade breakdown columns.
        $breakdown = [
            ['label' => 'Attendance', 'value' => $this->avgOf($grades, 'attendance_score')],
            ['label' => 'Assignments', 'value' => $this->avgOf($grades, 'assignment_score')],
            ['label' => 'Quizzes', 'value' => $this->avgOf($grades, 'quiz_score')],
            ['label' => 'Midterm', 'value' => $this->avgOf($grades, 'midterm_score')],
            ['label' => 'Final exam', 'value' => $this->avgOf($grades, 'final_exam_score')],
        ];

        $subjectPerformance = $grades
            ->filter(fn (Grade $grade) => $grade->course && $grade->total_score !== null)
            ->map(fn (Grade $grade) => [
                'name' => $grade->course->name,
                'score' => (int) round((float) $grade->total_score),
            ])
            ->sortByDesc('score')
            ->values();

        $insights = $this->buildInsights($overallGpa, $attendanceSummary['rate'], $gradedAttempts->avg('score'));

        return view('pages.student.analytics.index', [
            'overallGpa' => $overallGpa,
            'attendanceRate' => $attendanceSummary['rate'],
            'assignmentsDone' => $attemptCounts->count(),
            'assignmentsTotal' => $published->count(),
            'quizAverage' => $gradedAttempts->avg('score'),
            'gpaProgression' => $gpaProgression,
            'breakdown' => $breakdown,
            'subjectPerformance' => $subjectPerformance,
            'insights' => $insights,
        ]);
    }

    /**
     * Calendar: real class schedule (recurring weekly) + assignment due dates
     * for the student's enrolled courses.
     */
    public function calendar(Request $request): View
    {
        $student = $this->currentStudent();
        $courseIds = $this->enrolledCourseIds($student);

        $courses = $student
            ? $student->courses()->wherePivot('status', 'enrolled')->get()
            : collect();

        $assignments = Assignment::with('course')
            ->whereIn('course_id', $courseIds)
            ->where('status', 'published')
            ->whereNotNull('due_date')
            ->get();

        $month = $request->filled('month')
            ? Carbon::createFromFormat('!Y-m', $request->query('month'))
            : now()->startOfMonth();
        $monthStart = $month->copy()->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();
        $gridStart = $monthStart->copy()->startOfWeek(Carbon::SUNDAY);
        $gridEnd = $monthEnd->copy()->endOfWeek(Carbon::SATURDAY);

        $assignmentsByDate = $assignments
            ->groupBy(fn (Assignment $a) => $a->due_date->format('Y-m-d'));

        $days = [];
        $classEventCount = 0;
        $assignmentEventCount = 0;
        $cursor = $gridStart->copy();

        while ($cursor->lte($gridEnd)) {
            $dateKey = $cursor->format('Y-m-d');
            $dayEvents = [];

            foreach ($courses as $course) {
                if (! $course->day_of_week || strcasecmp($course->day_of_week, $cursor->format('l')) !== 0) {
                    continue;
                }
                $dayEvents[] = [
                    'type' => 'class',
                    'title' => $course->name,
                    'course' => $course->code,
                    'time' => $course->start_time ? substr($course->start_time, 0, 5) : '',
                    'detail' => trim(implode(' · ', array_filter([
                        $course->start_time ? substr($course->start_time, 0, 5) : null,
                        $course->end_time ? substr($course->end_time, 0, 5) : null,
                        $course->room,
                    ]))),
                ];
                if ($cursor->month === $monthStart->month) {
                    $classEventCount++;
                }
            }

            foreach ($assignmentsByDate->get($dateKey, []) as $assignment) {
                $dayEvents[] = [
                    'type' => $assignment->assignment_type === 'true_false' ? 'quiz' : 'assignment',
                    'title' => $assignment->title,
                    'course' => $assignment->course?->code,
                    'time' => $assignment->ends_at?->format('H:i') ?? '23:59',
                    'detail' => $assignment->course?->name,
                ];
                if ($cursor->month === $monthStart->month) {
                    $assignmentEventCount++;
                }
            }

            usort($dayEvents, fn ($a, $b) => strcmp($a['time'], $b['time']));

            $days[] = [
                'date' => $cursor->copy(),
                'events' => $dayEvents,
                'isCurrentMonth' => $cursor->month === $monthStart->month,
                'isToday' => $cursor->isToday(),
            ];
            $cursor->addDay();
        }

        // Summary counts for the current month.
        $classesThisWeek = $courses->filter(fn (Course $c) => $c->day_of_week
            && strcasecmp($c->day_of_week, now()->format('l')) === 0)->count();
        $upcomingQuizzes = $assignments->filter(fn (Assignment $a) => $a->assignment_type === 'true_false'
            && $a->due_date->isFuture())->count();
        $upcomingAssignments = $assignments->filter(fn (Assignment $a) => $a->assignment_type !== 'true_false'
            && $a->due_date->isFuture())->count();

        return view('pages.student.calendar.index', [
            'days' => $days,
            'monthLabel' => $monthStart->format('F Y'),
            'monthValue' => $monthStart->format('Y-m'),
            'previousMonth' => $monthStart->copy()->subMonth()->format('Y-m'),
            'nextMonth' => $monthStart->copy()->addMonth()->format('Y-m'),
            'classEventCount' => $classEventCount,
            'assignmentEventCount' => $assignmentEventCount,
            'classesToday' => $classesThisWeek,
            'upcomingAssignments' => $upcomingAssignments,
            'upcomingQuizzes' => $upcomingQuizzes,
        ]);
    }

    /**
     * Notifications: real notifications for the logged-in user, plus a
     * "mark all as read" action.
     */
    public function notifications(): View
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $all = Notification::where('user_id', Auth::id())->get();

        $summary = [
            'total' => $all->count(),
            'unread' => $all->where('is_read', false)->count(),
            'academic' => $all->filter(fn (Notification $n) => in_array($n->type, ['assignment', 'quiz', 'grade'], true))->count(),
            'system' => $all->filter(fn (Notification $n) => in_array($n->type, ['system', 'attendance', 'course'], true))->count(),
        ];

        // Upcoming deadlines for the sidebar.
        $student = $this->currentStudent();
        $courseIds = $this->enrolledCourseIds($student);
        $upcoming = Assignment::with('course')
            ->whereIn('course_id', $courseIds)
            ->where('status', 'published')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '>=', today())
            ->orderBy('due_date')
            ->limit(4)
            ->get();

        return view('pages.student.notifications.index', [
            'notifications' => $notifications,
            'summary' => $summary,
            'upcoming' => $upcoming,
        ]);
    }

    public function markAllNotificationsRead(): RedirectResponse
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return redirect()->route('student.notifications')
            ->with('status', 'All notifications marked as read.');
    }

    /**
     * Reports: real per-course performance, GPA, and attendance for the student.
     */
    public function reports(): View
    {
        $student = $this->currentStudent();

        $grades = $student
            ? Grade::with('course')->where('student_id', $student->id)->get()
            : collect();

        $gpaRecords = $student
            ? GpaRecord::with('semester')->where('student_id', $student->id)->orderBy('id')->get()
            : collect();

        $attendanceSummary = $this->attendanceSummary($student);

        $courseRows = $grades->map(function (Grade $grade) use ($student) {
            $courseAttendance = $student
                ? Attendance::where('student_id', $student->id)
                    ->where('course_id', $grade->course_id)
                    ->get()
                : collect();
            $attended = $courseAttendance->filter(fn (Attendance $r) => in_array($r->status, ['present', 'late'], true))->count();

            return [
                'name' => $grade->course?->name ?? 'Course unavailable',
                'code' => $grade->course?->code ?? '—',
                'total_score' => $grade->total_score !== null ? round((float) $grade->total_score, 2) : null,
                'letter_grade' => $grade->letter_grade ?? '—',
                'grade_point' => $grade->grade_point !== null ? round((float) $grade->grade_point, 2) : '—',
                'attendance' => $courseAttendance->count() > 0 ? (int) round($attended / $courseAttendance->count() * 100) : null,
                'status' => $grade->status,
            ];
        });

        $overallGpa = $gpaRecords->isNotEmpty()
            ? round((float) $gpaRecords->last()->gpa, 2)
            : ($grades->isNotEmpty() ? round((float) $grades->avg('grade_point'), 2) : null);

        $summary = [
            ['label' => 'Enrolled courses', 'value' => (string) $courseRows->count(), 'icon' => 'book'],
            ['label' => 'Overall GPA', 'value' => $overallGpa !== null ? number_format($overallGpa, 2) : '—', 'icon' => 'graph-up-arrow'],
            ['label' => 'Attendance rate', 'value' => $attendanceSummary['rate'] !== null ? $attendanceSummary['rate'] . '%' : '—', 'icon' => 'calendar-check'],
            ['label' => 'Graded courses', 'value' => (string) $courseRows->where('total_score', '!=', null)->count(), 'icon' => 'journal-check'],
        ];

        return view('pages.student.reports.index', [
            'courseRows' => $courseRows,
            'summary' => $summary,
            'overallGpa' => $overallGpa,
            'gpaRecords' => $gpaRecords,
            'attendanceSummary' => $attendanceSummary,
        ]);
    }

    /* ----------------------------------------------------------------
     |  Helpers
     | ---------------------------------------------------------------- */

    private function attendanceSummary(?Student $student): array
    {
        if (! $student) {
            return ['total' => 0, 'present' => 0, 'late' => 0, 'absent' => 0, 'rate' => null];
        }

        $rows = Attendance::where('student_id', $student->id)->get();
        $present = $rows->where('status', 'present')->count();
        $late = $rows->where('status', 'late')->count();
        $absent = $rows->where('status', 'absent')->count();
        $excused = $rows->where('status', 'excused')->count();
        $counted = $present + $late + $absent;

        return [
            'total' => $rows->count(),
            'present' => $present,
            'late' => $late,
            'absent' => $absent,
            'excused' => $excused,
            'rate' => $counted > 0 ? (int) round(($present + $late) / $counted * 100) : null,
        ];
    }

    private function gpaSummary(?Student $student): array
    {
        if (! $student) {
            return ['gpa' => null, 'credits' => 0, 'standing' => null];
        }

        $record = GpaRecord::where('student_id', $student->id)->latest('id')->first();

        return [
            'gpa' => $record ? round((float) $record->gpa, 2) : null,
            'credits' => $record ? (float) $record->earned_credits : 0,
            'standing' => $record?->academic_standing,
        ];
    }

    private function avgOf($collection, string $column): ?float
    {
        $values = $collection->filter(fn ($row) => $row->{$column} !== null)->pluck($column);

        return $values->isNotEmpty() ? round((float) $values->avg(), 1) : null;
    }

    private function buildInsights(?float $gpa, ?int $attendanceRate, ?float $quizAverage): array
    {
        $insights = [];

        if ($gpa !== null) {
            $insights[] = $gpa >= 3.5
                ? 'Strong academic standing with a ' . number_format($gpa, 2) . ' GPA. Keep it up!'
                : 'Your current GPA is ' . number_format($gpa, 2) . '. Focus on your weaker subjects to lift it.';
        }

        if ($attendanceRate !== null) {
            $insights[] = $attendanceRate >= 85
                ? 'Excellent attendance at ' . $attendanceRate . '%. Consistency pays off.'
                : 'Attendance is at ' . $attendanceRate . '%. Try not to miss upcoming classes.';
        }

        if ($quizAverage !== null) {
            $insights[] = $quizAverage >= 80
                ? 'Quiz average of ' . round($quizAverage) . '% shows solid understanding.'
                : 'Quiz average is ' . round($quizAverage) . '%. Reviewing past quizzes can help.';
        }

        if (empty($insights)) {
            $insights[] = 'Once you have grades, attendance, and quiz results, personalized insights will appear here.';
        }

        return $insights;
    }
}