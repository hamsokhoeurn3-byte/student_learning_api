<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\GpaRecord;
use App\Models\Grade;
use App\Models\LearningAnalytic;
use App\Models\Notification;
use App\Models\PerformanceRecord;
use App\Models\Prediction;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\Recommendation;
use App\Models\Report;
use App\Models\RiskAssessment;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Database\Seeders\Support\DemoRoster;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LearningDataSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $teachers = Teacher::all();
        $courses = Course::all();
        $activeYear = AcademicYear::where('status', 'active')->first() ?? AcademicYear::first();
        $semesters = Semester::all();

        if ($students->isEmpty() || $courses->isEmpty() || $semesters->isEmpty()) {
            return;
        }

        foreach ($students as $student) {
            // Enroll students in department courses for available semesters
            $deptCourses = Course::where('department_id', $student->department_id)->get();
            if ($deptCourses->isEmpty()) {
                $deptCourses = $courses;
            }

            foreach ($semesters as $semester) {
                foreach ($deptCourses as $course) {
                    $enrollment = CourseEnrollment::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'course_id' => $course->id,
                            'semester_id' => $semester->id,
                        ],
                        [
                            'enrollment_date' => $semester->start_date ?? now()->subMonths(3),
                            'status' => 'enrolled',
                            'final_score' => 85.5,
                            'grade' => 'A',
                        ]
                    );

                    // 1. Attendance & Attendance Details
                    $attendance = Attendance::firstOrCreate(
                        [
                            'course_id' => $course->id,
                            'semester_id' => $semester->id,
                            'attendance_date' => Carbon::parse($semester->start_date)->addDays(7)->toDateString(),
                        ],
                        [
                            'teacher_id' => $course->teacher_id ?? $teachers->first()->id,
                            'start_time' => '08:00:00',
                            'end_time' => '10:00:00',
                            'topic' => 'Lecture 1: Overview and Concepts',
                            'status' => 'completed',
                            'notes' => 'Regular session',
                        ]
                    );

                    AttendanceDetail::updateOrCreate(
                        [
                            'attendance_id' => $attendance->id,
                            'student_id' => $student->id,
                        ],
                        [
                            'status' => 'present',
                            'remarks' => 'On time',
                        ]
                    );

                    // 2. Assignment & Submission
                    $assignment = Assignment::firstOrCreate(
                        [
                            'course_id' => $course->id,
                            'semester_id' => $semester->id,
                            'title' => "Assignment 1: {$course->course_name} Fundamentals",
                        ],
                        [
                            'teacher_id' => $course->teacher_id ?? $teachers->first()->id,
                            'description' => "Complete core tasks for {$course->course_name}.",
                            'total_score' => 100,
                            'due_date' => Carbon::parse($semester->start_date)->addDays(14),
                            'status' => 'published',
                        ]
                    );

                    AssignmentSubmission::updateOrCreate(
                        [
                            'assignment_id' => $assignment->id,
                            'student_id' => $student->id,
                        ],
                        [
                            'submitted_at' => Carbon::parse($semester->start_date)->addDays(12),
                            'score' => rand(75, 95),
                            'feedback' => 'Good work!',
                            'status' => 'graded',
                            'file_path' => 'submissions/assignment_1.pdf',
                        ]
                    );

                    // 3. Quiz, Questions, Attempt & Answer
                    $quiz = Quiz::firstOrCreate(
                        [
                            'course_id' => $course->id,
                            'semester_id' => $semester->id,
                            'title' => "Quiz 1: Key Terms",
                        ],
                        [
                            'teacher_id' => $course->teacher_id ?? $teachers->first()->id,
                            'description' => 'Test your basic knowledge.',
                            'total_score' => 20,
                            'duration_minutes' => 30,
                            'start_at' => Carbon::parse($semester->start_date)->addDays(10),
                            'end_at' => Carbon::parse($semester->start_date)->addDays(11),
                            'status' => 'closed',
                        ]
                    );

                    $q1 = QuizQuestion::firstOrCreate(
                        [
                            'quiz_id' => $quiz->id,
                            'question_order' => 1,
                        ],
                        [
                            'question_text' => "What is a primary concept in {$course->course_name}?",
                            'question_type' => 'multiple_choice',
                            'marks' => 10,
                            'option_a' => 'Option A',
                            'option_b' => 'Option B',
                            'option_c' => 'Option C',
                            'option_d' => 'Option D',
                            'correct_answer' => 'A',
                        ]
                    );

                    $attempt = QuizAttempt::updateOrCreate(
                        [
                            'quiz_id' => $quiz->id,
                            'student_id' => $student->id,
                            'attempt_number' => 1,
                        ],
                        [
                            'started_at' => Carbon::parse($semester->start_date)->addDays(10)->addHours(2),
                            'submitted_at' => Carbon::parse($semester->start_date)->addDays(10)->addHours(2)->addMinutes(15),
                            'score' => 18.0,
                            'status' => 'completed',
                        ]
                    );

                    QuizAnswer::updateOrCreate(
                        [
                            'quiz_attempt_id' => $attempt->id,
                            'question_id' => $q1->id,
                        ],
                        [
                            'answer' => 'A',
                            'is_correct' => true,
                            'marks_obtained' => 10.0,
                        ]
                    );

                    // 4. Exam & Exam Result
                    $exam = Exam::firstOrCreate(
                        [
                            'course_id' => $course->id,
                            'semester_id' => $semester->id,
                            'title' => "Midterm Exam - {$course->course_code}",
                        ],
                        [
                            'teacher_id' => $course->teacher_id ?? $teachers->first()->id,
                            'exam_type' => 'midterm',
                            'exam_date' => Carbon::parse($semester->start_date)->addDays(45)->toDateString(),
                            'total_score' => 100,
                            'duration_minutes' => 120,
                            'description' => 'Midterm comprehensive evaluation',
                            'status' => 'completed',
                        ]
                    );

                    ExamResult::updateOrCreate(
                        [
                            'exam_id' => $exam->id,
                            'student_id' => $student->id,
                        ],
                        [
                            'score' => rand(70, 92),
                            'grade' => 'B+',
                            'remarks' => 'Solid performance',
                        ]
                    );

                    // 5. Grades
                    Grade::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'course_id' => $course->id,
                            'semester_id' => $semester->id,
                        ],
                        [
                            'assignment_score' => 88.0,
                            'quiz_score' => 90.0,
                            'attendance_score' => 95.0,
                            'midterm_score' => 82.0,
                            'final_exam_score' => 85.0,
                            'total_score' => 86.5,
                            'letter_grade' => 'A-',
                            'grade_point' => 3.67,
                            'status' => 'finalized',
                        ]
                    );

                    // 6. Performance Record
                    $periodStart = Carbon::parse($semester->start_date);
                    $periodEnd = Carbon::parse($semester->end_date ?? $periodStart->copy()->addMonths(4));
                    PerformanceRecord::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'course_id' => $course->id,
                            'semester_id' => $semester->id,
                            'period_type' => 'semester',
                            'period_start' => $periodStart->toDateString(),
                        ],
                        [
                            'period_end' => $periodEnd->toDateString(),
                            'attendance_percentage' => 95.0,
                            'assignment_percentage' => 88.0,
                            'quiz_percentage' => 90.0,
                            'exam_percentage' => 83.5,
                            'overall_score' => 86.5,
                            'performance_level' => 'good',
                        ]
                    );

                }

                // 7. Learning Analytic (Semester level per student)
                $periodStart = Carbon::parse($semester->start_date);
                $periodEnd = Carbon::parse($semester->end_date ?? $periodStart->copy()->addMonths(4));
                LearningAnalytic::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'period_type' => 'semester',
                        'period_start' => $periodStart->toDateString(),
                    ],
                    [
                        'semester_id' => $semester->id,
                        'period_end' => $periodEnd->toDateString(),
                        'attendance_rate' => 95.0,
                        'assignment_average' => 88.0,
                        'quiz_average' => 90.0,
                        'exam_average' => 83.5,
                        'overall_performance' => 86.5,
                        'performance_change' => 2.5,
                        'learning_trend' => 'improving',
                        'strengths' => json_encode(['Quizzes', 'Assignments']),
                        'weaknesses' => json_encode(['Time Management']),
                        'analytics_summary' => 'Consistent high performance with steady progress.',
                        'calculated_at' => now(),
                    ]
                );

                // 11. GPA Record
                GpaRecord::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'semester_id' => $semester->id,
                    ],
                    [
                        'gpa' => 3.65,
                        'total_credits' => 15.0,
                        'earned_credits' => 15.0,
                        'academic_standing' => 'good',
                    ]
                );
            }

            // 12. Notifications for Student
            if ($student->user_id) {
                Notification::updateOrCreate(
                    [
                        'user_id' => $student->user_id,
                        'title' => 'Welcome to SLAS',
                    ],
                    [
                        'message' => 'Your student dashboard and learning analytics are ready.',
                        'type' => 'system',
                        'is_read' => false,
                        'read_at' => null,
                    ]
                );
            }
        }

        // 13. System Reports
        $adminUser = User::where('role', 'admin')->first();
        Report::updateOrCreate(
            ['title' => 'Semester Academic Performance Summary'],
            [
                'report_type' => 'student_performance',
                'description' => 'Overall academic performance report across all departments',
                'generated_by' => $adminUser ? $adminUser->id : null,
                'generated_at' => now(),
                'file_path' => 'reports/semester_summary_2026.pdf',
                'status' => 'generated',
            ]
        );
    }
}
