<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Assignment;
use App\Models\AssignmentAttempt;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_and_view_a_course(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->post(route('admin.courses.store'), [
                'name' => 'Data Structures',
                'code' => 'CS101',
                'department' => 'Computer Science',
                'day_of_week' => 'Monday',
                'start_time' => '09:00',
                'end_time' => '10:30',
                'room' => 'Room A1',
                'status' => 'active',
            ])
            ->assertRedirect(route('admin.assign-class'));

        $this->assertDatabaseHas('courses', [
            'name' => 'Data Structures',
            'code' => 'CS101',
            'day_of_week' => 'Monday',
            'start_time' => '09:00',
            'end_time' => '10:30',
            'room' => 'Room A1',
        ]);

        $this->get(route('admin.assign-class'))
            ->assertOk()
            ->assertSee('Data Structures')
            ->assertSee('CS101');
    }

    public function test_admin_class_creation_is_persisted_to_the_classes_table(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->post(route('admin.courses.store'), [
                'name' => 'Web Development',
                'code' => 'CS102',
                'department' => 'Computer Science',
                'credits' => 3,
                'status' => 'active',
            ])
            ->assertRedirect(route('admin.assign-class'));

        $this->assertDatabaseHas('courses', [
            'name' => 'Web Development',
            'code' => 'CS102',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('classes', [
            'name' => 'Web Development',
            'code' => 'CS102',
            'status' => 'active',
        ]);
    }

    public function test_admin_can_view_edit_and_delete_a_course_and_its_assignments(): void
    {
        $admin = $this->createAdmin();
        $course = Course::create([
            'name' => 'Data Structures',
            'code' => 'CS101',
            'department' => 'Computer Science',
            'credits' => 3,
            'academic_year' => '2026-2027',
            'semester' => 'Semester 1',
            'status' => 'active',
        ]);
        $assignment = $course->assignments()->create([
            'title' => 'Linked List Project',
            'status' => 'published',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.courses.show', $course))
            ->assertOk()
            ->assertSee('Data Structures')
            ->assertSee('3');

        $this->get(route('admin.courses.edit', $course))
            ->assertOk()
            ->assertSee('academic_year')
            ->assertSee('teacher_id');

        $this->put(route('admin.courses.update', $course), [
            'name' => 'Advanced Data Structures',
            'code' => 'CS101',
            'department' => 'Computer Science',
            'credits' => 4,
            'academic_year' => '2026-2027',
            'semester' => 'Semester 2',
            'status' => 'active',
        ])->assertRedirect(route('admin.courses.show', $course));

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Advanced Data Structures',
            'credits' => 4,
        ]);

        $this->delete(route('admin.courses.destroy', $course))
            ->assertRedirect(route('admin.courses'));

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
        $this->assertDatabaseMissing('assignments', ['id' => $assignment->id]);
    }

    public function test_admin_can_enroll_student_and_assigned_teacher_sees_them(): void
    {
        $admin = $this->createAdmin();
        $teacherUser = User::create([
            'name' => 'Teacher One',
            'email' => 'teacher.roster@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH777',
            'first_name' => 'Teacher',
            'last_name' => 'One',
            'status' => 'active',
        ]);
        $course = Course::create([
            'name' => 'Data Structures',
            'code' => 'CS777',
            'academic_year' => '2026-2027',
            'semester' => 'Semester 1',
            'status' => 'active',
        ]);
        $studentUser = User::create([
            'name' => 'Student One',
            'email' => 'student.roster@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STD777',
            'first_name' => 'Student',
            'last_name' => 'One',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Male',
            'status' => 'enrolled',
        ]);
        $otherStudentUser = User::create([
            'name' => 'Unassigned Student',
            'email' => 'student.unassigned.roster@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $otherStudent = Student::create([
            'user_id' => $otherStudentUser->id,
            'student_id' => 'STD778',
            'first_name' => 'Unassigned',
            'last_name' => 'Student',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Female',
            'status' => 'enrolled',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.courses.show', $course))
            ->assertOk()
            ->assertSee('Assign class teacher')
            ->assertSee('Add assignment to this class');

        $this->put(route('admin.courses.teacher.update', $course), [
            'teacher_id' => $teacher->id,
        ])->assertRedirect(route('admin.courses.show', $course));

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'teacher_id' => $teacher->id,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.courses.students.store', $course), [
                'student_ids' => [$student->id],
            ])
            ->assertRedirect(route('admin.courses.show', $course));

        $this->assertDatabaseHas('course_student', [
            'course_id' => $course->id,
            'student_id' => $student->id,
            'status' => 'enrolled',
        ]);

        $this->post(route('admin.assignments.store'), [
            'course_id' => $course->id,
            'title' => 'Class-specific assignment',
            'description' => 'Created from this class page.',
            'due_date' => '2026-10-20',
            'status' => 'published',
        ])->assertRedirect(route('admin.assignments'));

        $this->assertDatabaseHas('assignments', [
            'course_id' => $course->id,
            'title' => 'Class-specific assignment',
        ]);

        $this->actingAs($teacherUser)
            ->get(route('teacher.students'))
            ->assertOk()
            ->assertSee('Student One')
            ->assertSee('CS777')
            ->assertSee(route('teacher.students.show', $student))
            ->assertDontSee('Add Student');

        $this->post(route('admin.students.store'), [])->assertForbidden();

        $this->get(route('teacher.students.show', $student))
            ->assertOk()
            ->assertSee('Student One')
            ->assertSee('STD777')
            ->assertSee('Data Structures');

        $this->get(route('teacher.students.show', $otherStudent))->assertNotFound();

        $this->get(route('teacher.students', ['search' => 'STD777']))
            ->assertOk()
            ->assertSee('Student One');

        $this->get(route('teacher.students', ['search' => 'missing-student']))
            ->assertOk()
            ->assertSee('No assigned students match your search.')
            ->assertDontSee('Student One');

        $this->actingAs($studentUser)
            ->get(route('student.courses'))
            ->assertOk()
            ->assertSee('Data Structures')
            ->assertSee('CS777');
    }

    public function test_admin_can_create_an_assignment_for_an_existing_course(): void
    {
        $admin = $this->createAdmin();
        $course = Course::create([
            'name' => 'Data Structures',
            'code' => 'CS101',
            'status' => 'active',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.assignments.store'), [
                'course_id' => $course->id,
                'title' => 'Linked List Project',
                'description' => 'Implement a linked list.',
                'due_date' => '2026-10-15',
                'status' => 'published',
            ])
            ->assertRedirect(route('admin.assignments'));

        $this->assertDatabaseHas('assignments', [
            'course_id' => $course->id,
            'title' => 'Linked List Project',
            'created_by' => $admin->id,
        ]);

        $this->get(route('admin.assignments'))
            ->assertOk()
            ->assertSee('Linked List Project')
            ->assertSee('CS101');
    }

    public function test_teacher_sees_admin_assigned_courses_and_can_create_assignments_for_them(): void
    {
        $teacherUser = User::create([
            'name' => 'Teacher One',
            'email' => 'teacher.assignments@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH778',
            'first_name' => 'Teacher',
            'last_name' => 'One',
            'status' => 'active',
        ]);
        $assignedCourse = Course::create([
            'name' => 'Assigned Web Development',
            'code' => 'WD778',
            'teacher_id' => $teacher->id,
            'status' => 'active',
        ]);
        $otherTeacherUser = User::create([
            'name' => 'Teacher Two',
            'email' => 'teacher.two.assignments@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $otherTeacher = Teacher::create([
            'user_id' => $otherTeacherUser->id,
            'teacher_id' => 'TCH779',
            'first_name' => 'Teacher',
            'last_name' => 'Two',
            'status' => 'active',
        ]);
        $otherTeacherCourse = Course::create([
            'name' => 'Other Teacher Course',
            'code' => 'OT779',
            'teacher_id' => $otherTeacher->id,
            'status' => 'active',
        ]);
        $unassignedCourse = Course::create([
            'name' => 'Unassigned Database Systems',
            'code' => 'DB778',
            'status' => 'active',
        ]);
        $enrolledStudentUser = User::create([
            'name' => 'Assigned Student',
            'email' => 'student.assigned.assignment@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $enrolledStudent = Student::create([
            'user_id' => $enrolledStudentUser->id,
            'student_id' => 'STD781',
            'first_name' => 'Assigned',
            'last_name' => 'Student',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Female',
            'status' => 'enrolled',
        ]);
        $otherStudentUser = User::create([
            'name' => 'Other Class Student',
            'email' => 'student.other.assignment@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        Student::create([
            'user_id' => $otherStudentUser->id,
            'student_id' => 'STD782',
            'first_name' => 'Other Class',
            'last_name' => 'Student',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Male',
            'status' => 'enrolled',
        ]);
        $assignedCourse->students()->attach($enrolledStudent->id, ['status' => 'enrolled']);

        $this->actingAs($teacherUser)
            ->get(route('teacher.courses'))
            ->assertOk()
            ->assertSee('Assigned Web Development')
            ->assertDontSee('Unassigned Database Systems')
            ->assertDontSee('Other Teacher Course');

        $this->get(route('teacher.courses.show', $assignedCourse))
            ->assertOk()
            ->assertSee('Assigned Web Development')
            ->assertSee('WD778')
            ->assertDontSee('Edit course')
            ->assertDontSee('Delete course');

        $this->get(route('teacher.courses.show', $otherTeacherCourse))
            ->assertNotFound();

        $this->get(route('teacher.courses.show', $unassignedCourse))
            ->assertNotFound();

        $this->get(route('teacher.assignments'))
            ->assertOk()
            ->assertSee('Assigned Web Development')
            ->assertDontSee('Unassigned Database Systems');

        $this->post(route('teacher.assignments.store'), [
            'course_id' => $assignedCourse->id,
            'title' => 'Build a portfolio',
            'description' => 'Create a responsive portfolio site.',
            'starts_at' => '2026-10-20T08:30',
            'ends_at' => '2026-10-22T10:00',
            'assignment_type' => 'file_upload',
            'allow_retakes' => '0',
            'status' => 'published',
        ])->assertRedirect(route('teacher.assignments'));

        $this->assertDatabaseHas('assignments', [
            'course_id' => $assignedCourse->id,
            'title' => 'Build a portfolio',
            'created_by' => $teacherUser->id,
            'starts_at' => '2026-10-20 08:30:00',
            'ends_at' => '2026-10-22 10:00:00',
        ]);
        $this->assertTrue(\Illuminate\Support\Facades\DB::table('assignments')
            ->where('course_id', $assignedCourse->id)
            ->where('title', 'Build a portfolio')
            ->whereDate('due_date', '2026-10-22')
            ->exists());

        $this->actingAs($enrolledStudentUser)
            ->get(route('student.courses'))
            ->assertOk()
            ->assertSee('Build a portfolio')
            ->assertSee('Starts Oct 20, 2026 08:30')
            ->assertSee('Due Oct 22, 2026 10:00');

        $this->actingAs($otherStudentUser)
            ->get(route('student.courses'))
            ->assertOk()
            ->assertDontSee('Build a portfolio');

        $this->actingAs($teacherUser);
        $this->post(route('teacher.assignments.store'), [
            'course_id' => $unassignedCourse->id,
            'title' => 'Unauthorized assignment',
            'starts_at' => '2026-10-20T08:30',
            'ends_at' => '2026-10-20T10:00',
            'assignment_type' => 'file_upload',
            'status' => 'draft',
        ])->assertNotFound();

        $this->assertDatabaseMissing('assignments', [
            'course_id' => $unassignedCourse->id,
            'title' => 'Unauthorized assignment',
        ]);
    }

    public function test_student_quizzes_page_shows_only_published_quizzes_from_enrolled_courses(): void
    {
        $studentUser = User::create([
            'name' => 'Quiz List Student',
            'email' => 'student.quiz-list@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STD895',
            'first_name' => 'Quiz List',
            'last_name' => 'Student',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Female',
            'status' => 'enrolled',
        ]);
        $course = Course::create([
            'name' => 'Teacher Assigned Biology',
            'code' => 'BIO895',
            'status' => 'active',
        ]);
        $course->students()->attach($student->id, ['status' => 'enrolled']);
        $quiz = Assignment::create([
            'course_id' => $course->id,
            'title' => 'Cell Biology Quiz',
            'description' => 'A real quiz assigned to the enrolled class.',
            'assignment_type' => 'true_false',
            'status' => 'published',
            'due_date' => now()->addDays(2)->toDateString(),
            'ends_at' => now()->addDays(2),
        ]);
        $quiz->questions()->create([
            'prompt' => 'Cells are the basic unit of life.',
            'correct_answer' => true,
            'position' => 0,
        ]);

        $hiddenCourse = Course::create([
            'name' => 'Not Enrolled Physics',
            'code' => 'PHY895',
            'status' => 'active',
        ]);
        Assignment::create([
            'course_id' => $hiddenCourse->id,
            'title' => 'Unassigned Physics Quiz',
            'assignment_type' => 'true_false',
            'status' => 'published',
        ]);
        Assignment::create([
            'course_id' => $course->id,
            'title' => 'Draft Biology Quiz',
            'assignment_type' => 'true_false',
            'status' => 'draft',
        ]);

        $this->actingAs($studentUser)
            ->get(route('student.quizzes'))
            ->assertOk()
            ->assertSee('Cell Biology Quiz')
            ->assertSee('BIO895')
            ->assertSee('Teacher Assigned Biology')
            ->assertDontSee('Unassigned Physics Quiz')
            ->assertDontSee('Draft Biology Quiz')
            ->assertDontSee('Arrays Practice Quiz');
    }

    public function test_student_global_search_returns_only_enrolled_courses_and_published_work(): void
    {
        $studentUser = User::create([
            'name' => 'Search Student',
            'email' => 'student.search@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STD892',
            'first_name' => 'Search',
            'last_name' => 'Student',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Female',
            'status' => 'enrolled',
        ]);
        $enrolledCourse = Course::create([
            'name' => 'World History',
            'code' => 'HIS892',
            'status' => 'active',
        ]);
        $unassignedCourse = Course::create([
            'name' => 'Hidden History',
            'code' => 'HIS893',
            'status' => 'active',
        ]);
        $enrolledCourse->students()->attach($student->id, ['status' => 'enrolled']);
        Assignment::create([
            'course_id' => $enrolledCourse->id,
            'title' => 'History Chapter Quiz',
            'description' => 'Review world history.',
            'assignment_type' => 'true_false',
            'status' => 'published',
        ]);
        Assignment::create([
            'course_id' => $unassignedCourse->id,
            'title' => 'Hidden History Assignment',
            'assignment_type' => 'file_upload',
            'status' => 'published',
        ]);

        $this->actingAs($studentUser)
            ->get(route('student.search', ['q' => 'history']))
            ->assertOk()
            ->assertSee('World History')
            ->assertSee('History Chapter Quiz')
            ->assertDontSee('Hidden History');
    }

    public function test_teacher_can_view_edit_and_delete_only_their_own_class_assignments(): void
    {
        Storage::fake('local');
        $teacherUser = User::create([
            'name' => 'CRUD Teacher',
            'email' => 'teacher.crud@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH785',
            'first_name' => 'CRUD',
            'last_name' => 'Teacher',
            'status' => 'active',
        ]);
        $otherTeacherUser = User::create([
            'name' => 'Other CRUD Teacher',
            'email' => 'teacher.other.crud@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $otherTeacher = Teacher::create([
            'user_id' => $otherTeacherUser->id,
            'teacher_id' => 'TCH786',
            'first_name' => 'Other',
            'last_name' => 'Teacher',
            'status' => 'active',
        ]);
        $course = Course::create([
            'name' => 'CRUD Class',
            'code' => 'CRUD785',
            'teacher_id' => $teacher->id,
            'status' => 'active',
        ]);
        $otherCourse = Course::create([
            'name' => 'Other CRUD Class',
            'code' => 'CRUD786',
            'teacher_id' => $otherTeacher->id,
            'status' => 'active',
        ]);
        $assignment = $course->assignments()->create([
            'created_by' => $teacherUser->id,
            'title' => 'My CRUD Assignment',
            'description' => 'Original instructions.',
            'starts_at' => '2026-10-20 08:30:00',
            'ends_at' => '2026-10-22 10:00:00',
            'due_date' => '2026-10-22',
            'status' => 'published',
        ]);
        $question = $assignment->questions()->create([
            'prompt' => 'Cleanup question',
            'correct_answer' => true,
            'position' => 0,
        ]);
        $attemptStudentUser = User::create([
            'name' => 'Cleanup Student',
            'email' => 'student.cleanup@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $attemptStudent = Student::create([
            'user_id' => $attemptStudentUser->id,
            'student_id' => 'STD785',
            'first_name' => 'Cleanup',
            'last_name' => 'Student',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Female',
            'status' => 'enrolled',
        ]);
        $submissionPath = 'assignment-submissions/cleanup/work.pdf';
        Storage::disk('local')->put($submissionPath, 'sample file');
        $attempt = $assignment->attempts()->create([
            'student_id' => $attemptStudent->id,
            'attempt_number' => 1,
            'started_at' => '2026-10-20 08:30:00',
            'submitted_at' => '2026-10-20 08:45:00',
            'file_path' => $submissionPath,
            'file_name' => 'work.pdf',
        ]);
        $otherAssignment = $otherCourse->assignments()->create([
            'created_by' => $otherTeacherUser->id,
            'title' => 'Other Teacher Assignment',
            'starts_at' => '2026-10-20 08:30:00',
            'ends_at' => '2026-10-22 10:00:00',
            'due_date' => '2026-10-22',
            'status' => 'published',
        ]);

        $this->actingAs($teacherUser)
            ->get(route('teacher.assignments'))
            ->assertOk()
            ->assertSee('My CRUD Assignment')
            ->assertSee(route('teacher.assignments.edit', $assignment))
            ->assertDontSee('Other Teacher Assignment');

        $this->get(route('teacher.assignments.show', $assignment))
            ->assertOk()
            ->assertSee('My CRUD Assignment')
            ->assertSee('Original instructions.');

        $this->get(route('teacher.assignments.edit', $assignment))
            ->assertOk()
            ->assertSee('2026-10-20T08:30');

        $this->put(route('teacher.assignments.update', $assignment), [
            'course_id' => $course->id,
            'title' => 'Updated CRUD Assignment',
            'description' => 'Updated instructions.',
            'starts_at' => '2026-10-21T09:00',
            'ends_at' => '2026-10-23T11:30',
            'assignment_type' => 'file_upload',
            'allow_retakes' => '0',
            'status' => 'draft',
        ])->assertRedirect(route('teacher.assignments.show', $assignment));

        $this->assertDatabaseHas('assignments', [
            'id' => $assignment->id,
            'title' => 'Updated CRUD Assignment',
            'description' => 'Updated instructions.',
            'starts_at' => '2026-10-21 09:00:00',
            'ends_at' => '2026-10-23 11:30:00',
            'status' => 'draft',
        ]);

        $this->get(route('teacher.assignments.show', $otherAssignment))->assertNotFound();
        $this->put(route('teacher.assignments.update', $otherAssignment), [
            'course_id' => $otherCourse->id,
            'title' => 'Tampered Assignment',
            'starts_at' => '2026-10-21T09:00',
            'ends_at' => '2026-10-23T11:30',
            'status' => 'draft',
        ])->assertNotFound();
        $this->delete(route('teacher.assignments.destroy', $otherAssignment))->assertNotFound();

        $this->delete(route('teacher.assignments.destroy', $assignment))
            ->assertRedirect(route('teacher.assignments'));
        $this->assertDatabaseMissing('assignments', ['id' => $assignment->id]);
        $this->assertDatabaseMissing('assignment_questions', ['id' => $question->id]);
        $this->assertDatabaseMissing('assignment_attempts', ['id' => $attempt->id]);
        $this->assertFalse(Storage::disk('local')->exists($submissionPath));
    }

    public function test_teacher_can_create_true_false_assignment_and_student_can_use_configured_retakes(): void
    {
        $teacherUser = User::create([
            'name' => 'Quiz Teacher',
            'email' => 'teacher.truefalse@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH787',
            'first_name' => 'Quiz',
            'last_name' => 'Teacher',
            'status' => 'active',
        ]);
        $course = Course::create([
            'name' => 'True False Class',
            'code' => 'TF787',
            'teacher_id' => $teacher->id,
            'status' => 'active',
        ]);
        $studentUser = User::create([
            'name' => 'Quiz Student',
            'email' => 'student.truefalse@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STD787',
            'first_name' => 'Quiz',
            'last_name' => 'Student',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Female',
            'status' => 'enrolled',
        ]);
        $course->students()->attach($student->id, ['status' => 'enrolled']);

        $this->travelTo(\Illuminate\Support\Carbon::parse('2026-10-02 12:00:00'));
        $this->actingAs($teacherUser)
            ->post(route('teacher.assignments.store'), [
                'course_id' => $course->id,
                'title' => 'True False Quiz',
                'content_type' => 'quiz',
                'description' => 'Answer both questions.',
                'starts_at' => '2026-10-02T08:00',
                'ends_at' => '2026-10-02T15:00',
                'assignment_type' => 'true_false',
                'allow_retakes' => '1',
                'max_attempts' => '2',
                'status' => 'published',
                'questions' => [
                    ['prompt' => 'The Earth orbits the Sun.', 'correct_answer' => 'true'],
                    ['prompt' => 'Two plus two equals five.', 'correct_answer' => 'false'],
                ],
            ])
            ->assertRedirect(route('teacher.quizzes'));

        $assignment = \App\Models\Assignment::where('title', 'True False Quiz')->firstOrFail();
        $this->assertDatabaseHas('assignments', [
            'id' => $assignment->id,
            'assignment_type' => 'true_false',
            'allow_retakes' => 1,
            'max_attempts' => 2,
        ]);
        $questionIds = \App\Models\AssignmentQuestion::where('assignment_id', $assignment->id)
            ->orderBy('position')
            ->pluck('id');
        $this->assertCount(2, $questionIds);
        $this->actingAs($teacherUser)
            ->get(route('teacher.assignments'))
            ->assertOk()
            ->assertSee('Questions and answers - True / False')
            ->assertSee('Add question')
            ->assertSee('Allow retakes');
        $this->get(route('teacher.quizzes'))
            ->assertOk()
            ->assertSee('True False Quiz')
            ->assertSee('Create Quiz')
            ->assertSee('Quiz type')
            ->assertDontSee('Create Assignment');
        $this->get(route('teacher.assignments.show', $assignment))
            ->assertOk()
            ->assertSee('The Earth orbits the Sun.')
            ->assertSee('True');

        $this->actingAs($studentUser)
            ->get(route('student.assignments'))
            ->assertOk()
            ->assertSee('True False Quiz');
        $this->get(route('student.assignments.submit', $assignment))
            ->assertOk()
            ->assertSee('The Earth orbits the Sun.')
            ->assertDontSee('correct_answer');

        $this->post(route('student.assignments.store', $assignment), [
            'answers' => [$questionIds[0] => 'true', $questionIds[1] => 'true'],
        ])->assertRedirect(route('student.assignments.result', $assignment));
        $this->assertDatabaseHas('assignment_attempts', [
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'score' => 50,
        ]);

        $this->post(route('student.assignments.store', $assignment), [
            'answers' => [$questionIds[0] => 'true', $questionIds[1] => 'false'],
        ])->assertRedirect(route('student.assignments.result', $assignment));
        $this->assertDatabaseHas('assignment_attempts', [
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
            'attempt_number' => 2,
            'score' => 100,
        ]);

        $this->post(route('student.assignments.store', $assignment), [
            'answers' => [$questionIds[0] => 'true', $questionIds[1] => 'false'],
        ])->assertForbidden();

        $this->actingAs($teacherUser)
            ->put(route('teacher.assignments.update', $assignment), [
                'course_id' => $course->id,
                'title' => 'Updated True False Quiz',
                'description' => 'One revised question.',
                'starts_at' => '2026-10-02T08:00',
                'ends_at' => '2026-10-02T15:00',
                'assignment_type' => 'true_false',
                'allow_retakes' => '1',
                'max_attempts' => '3',
                'status' => 'published',
                'questions' => [
                    ['prompt' => 'A week has seven days.', 'correct_answer' => 'true'],
                ],
            ])
            ->assertRedirect(route('teacher.assignments.show', $assignment));

        $this->assertDatabaseHas('assignments', [
            'id' => $assignment->id,
            'title' => 'Updated True False Quiz',
            'max_attempts' => 3,
        ]);
        $this->assertDatabaseHas('assignment_questions', [
            'assignment_id' => $assignment->id,
            'prompt' => 'A week has seven days.',
        ]);

        $this->delete(route('teacher.assignments.destroy', $assignment))
            ->assertRedirect(route('teacher.quizzes'));
        $this->assertDatabaseMissing('assignments', ['id' => $assignment->id]);
    }

    public function test_student_file_submission_is_private_and_limited_to_enrolled_class_members(): void
    {
        Storage::fake('local');
        $teacherUser = User::create([
            'name' => 'File Teacher',
            'email' => 'teacher.file@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH788',
            'first_name' => 'File',
            'last_name' => 'Teacher',
            'status' => 'active',
        ]);
        $course = Course::create([
            'name' => 'File Upload Class',
            'code' => 'FU788',
            'teacher_id' => $teacher->id,
            'status' => 'active',
        ]);
        $studentUser = User::create([
            'name' => 'File Student',
            'email' => 'student.file@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STD788',
            'first_name' => 'File',
            'last_name' => 'Student',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Male',
            'status' => 'enrolled',
        ]);
        $course->students()->attach($student->id, ['status' => 'enrolled']);
        $assignment = $course->assignments()->create([
            'created_by' => $teacherUser->id,
            'title' => 'Upload your work',
            'assignment_type' => 'file_upload',
            'starts_at' => '2026-10-01 08:00:00',
            'ends_at' => '2026-10-03 15:00:00',
            'due_date' => '2026-10-03',
            'status' => 'published',
        ]);

        $this->travelTo(\Illuminate\Support\Carbon::parse('2026-10-02 12:00:00'));
        $this->actingAs($studentUser)
            ->post(route('student.assignments.store', $assignment), [
                'submission_file' => UploadedFile::fake()->create('project.pdf', 120, 'application/pdf'),
            ])
            ->assertRedirect(route('student.assignments.result', $assignment));

        $attempt = \App\Models\AssignmentAttempt::where('assignment_id', $assignment->id)->firstOrFail();
        $this->assertTrue(Storage::disk('local')->exists($attempt->file_path));

        $this->actingAs($teacherUser)
            ->get(route('teacher.assignments.show', $assignment))
            ->assertOk()
            ->assertSee('File Student')
            ->assertSee('project.pdf');
        $this->get(route('teacher.assignments.attempts.download', [$assignment, $attempt]))
            ->assertOk()
            ->assertDownload('project.pdf');

        $this->actingAs($studentUser);
        $this->post(route('student.assignments.store', $assignment), [
            'submission_file' => UploadedFile::fake()->create('retake.pdf', 120, 'application/pdf'),
        ])->assertForbidden();
    }

    public function test_teacher_can_mark_attendance_only_for_students_in_assigned_classes(): void
    {
        $teacherUser = User::create([
            'name' => 'Attendance Teacher',
            'email' => 'teacher.attendance@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH779',
            'first_name' => 'Attendance',
            'last_name' => 'Teacher',
            'status' => 'active',
        ]);
        $course = Course::create([
            'name' => 'Attendance Class',
            'code' => 'AT779',
            'teacher_id' => $teacher->id,
            'day_of_week' => 'Friday',
            'start_time' => '09:00',
            'end_time' => '10:30',
            'status' => 'active',
        ]);
        $studentUser = User::create([
            'name' => 'Enrolled Student',
            'email' => 'student.attendance@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STD779',
            'first_name' => 'Enrolled',
            'last_name' => 'Student',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Female',
            'status' => 'enrolled',
        ]);
        $otherStudentUser = User::create([
            'name' => 'Other Student',
            'email' => 'student.other.attendance@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $otherStudent = Student::create([
            'user_id' => $otherStudentUser->id,
            'student_id' => 'STD780',
            'first_name' => 'Other',
            'last_name' => 'Student',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Male',
            'status' => 'enrolled',
        ]);
        $course->students()->attach($student->id, ['status' => 'enrolled']);

        $this->travelTo(\Illuminate\Support\Carbon::parse('2026-10-02 08:59:00'));

        $this->actingAs($teacherUser)
            ->get(route('teacher.attendance'))
            ->assertOk()
            ->assertSee('Enrolled Student')
            ->assertDontSee('Other Student');

        $this->get(route('teacher.calendar', ['month' => '2026-10']))
            ->assertOk()
            ->assertSee('Attendance available at 09:00')
            ->assertDontSee('Take attendance for Attendance Class');

        $this->post(route('teacher.attendance.store'), [
            'course_id' => $course->id,
            'attendance_date' => '2026-10-02',
            'attendance' => [$student->id => 'present'],
        ])->assertForbidden();

        $this->travelTo(\Illuminate\Support\Carbon::parse('2026-10-02 09:00:00'));

        $this->get(route('teacher.calendar', ['month' => '2026-10']))
            ->assertOk()
            ->assertSee('Take attendance for Attendance Class');

        $this->post(route('teacher.attendance.store'), [
            'course_id' => $course->id,
            'attendance_date' => '2026-10-02',
            'attendance' => [$student->id => 'present'],
        ])->assertRedirect(route('teacher.attendance', [
            'course_id' => $course->id,
            'date' => '2026-10-02',
        ]));

        $this->assertDatabaseHas('attendances', [
            'course_id' => $course->id,
            'student_id' => $student->id,
            'status' => 'present',
            'marked_by' => $teacherUser->id,
        ]);
        $this->assertTrue(\Illuminate\Support\Facades\DB::table('attendances')
            ->where('course_id', $course->id)
            ->where('student_id', $student->id)
            ->whereDate('attendance_date', '2026-10-02')
            ->exists());

        $this->post(route('teacher.attendance.store'), [
            'course_id' => $course->id,
            'attendance_date' => '2026-10-02',
            'attendance' => [$otherStudent->id => 'absent'],
        ])->assertForbidden();

        $this->assertDatabaseMissing('attendances', [
            'course_id' => $course->id,
            'student_id' => $otherStudent->id,
        ]);
    }

    public function test_teacher_grades_and_quizzes_start_without_placeholder_records(): void
    {
        $teacherUser = User::create([
            'name' => 'Empty Pages Teacher',
            'email' => 'teacher.empty-pages@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);

        $this->actingAs($teacherUser)
            ->get(route('teacher.grades'))
            ->assertOk()
            ->assertSee('No student submissions to grade yet.')
            ->assertSee('Awaiting score')
            ->assertDontSee('Sok Dara');

        $this->get(route('teacher.quizzes'))
            ->assertOk()
            ->assertSee('No quizzes yet.')
            ->assertSee('Showing 0–0 of 0 quizzes')
            ->assertDontSee('Data Structures');
    }

    public function test_teacher_can_grade_submissions_only_in_assigned_courses_and_students_can_view_scores(): void
    {
        $teacherUser = User::create([
            'name' => 'Grading Teacher',
            'email' => 'teacher.grading@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH890',
            'first_name' => 'Grading',
            'last_name' => 'Teacher',
            'status' => 'active',
        ]);
        $course = Course::create([
            'name' => 'Grading Course',
            'code' => 'GR890',
            'teacher_id' => $teacher->id,
            'status' => 'active',
        ]);
        $studentUser = User::create([
            'name' => 'Graded Student',
            'email' => 'student.grading@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STD890',
            'first_name' => 'Graded',
            'last_name' => 'Student',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Female',
            'status' => 'enrolled',
        ]);
        $course->students()->attach($student->id, ['status' => 'enrolled']);

        $assignment = Assignment::create([
            'course_id' => $course->id,
            'created_by' => $teacherUser->id,
            'title' => 'Graded Assignment',
            'assignment_type' => 'file_upload',
            'status' => 'published',
        ]);
        $attempt = AssignmentAttempt::create([
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'started_at' => now(),
            'submitted_at' => now(),
            'file_name' => 'work.pdf',
        ]);
        $quiz = Assignment::create([
            'course_id' => $course->id,
            'created_by' => $teacherUser->id,
            'title' => 'Graded Quiz',
            'assignment_type' => 'true_false',
            'status' => 'published',
        ]);
        $quizAttempt = AssignmentAttempt::create([
            'assignment_id' => $quiz->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'started_at' => now(),
            'submitted_at' => now(),
            'score' => 100,
        ]);

        $otherTeacherUser = User::create([
            'name' => 'Other Grading Teacher',
            'email' => 'teacher.other-grading@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $otherTeacher = Teacher::create([
            'user_id' => $otherTeacherUser->id,
            'teacher_id' => 'TCH891',
            'first_name' => 'Other',
            'last_name' => 'Teacher',
            'status' => 'active',
        ]);
        $otherCourse = Course::create([
            'name' => 'Other Grading Course',
            'code' => 'GR891',
            'teacher_id' => $otherTeacher->id,
            'status' => 'active',
        ]);
        $otherAssignment = Assignment::create([
            'course_id' => $otherCourse->id,
            'created_by' => $otherTeacherUser->id,
            'title' => 'Other Teacher Assignment',
            'assignment_type' => 'file_upload',
            'status' => 'published',
        ]);
        $otherAttempt = AssignmentAttempt::create([
            'assignment_id' => $otherAssignment->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'started_at' => now(),
            'submitted_at' => now(),
        ]);

        $this->actingAs($teacherUser)
            ->get(route('teacher.grades'))
            ->assertOk()
            ->assertSee('Graded Assignment')
            ->assertSee('Graded Quiz')
            ->assertDontSee('Other Teacher Assignment');

        $this->put(route('teacher.grades.update', $attempt), [
            'score' => '87.5',
        ])->assertRedirect(route('teacher.grades'));

        $this->put(route('teacher.grades.update', $quizAttempt), [
            'score' => '92',
        ])->assertRedirect(route('teacher.grades'));

        $this->put(route('teacher.grades.update', $otherAttempt), [
            'score' => '50',
        ])->assertNotFound();

        $this->assertDatabaseHas('assignment_attempts', [
            'id' => $attempt->id,
            'score' => '87.50',
        ]);
        $this->assertDatabaseHas('assignment_attempts', [
            'id' => $quizAttempt->id,
            'score' => '92.00',
        ]);
        $this->assertDatabaseHas('assignment_attempts', [
            'id' => $otherAttempt->id,
            'score' => null,
        ]);

        $this->actingAs($studentUser)
            ->get(route('student.grades'))
            ->assertOk()
            ->assertSee('Graded Assignment')
            ->assertSee('Graded Quiz')
            ->assertSee('87.50%')
            ->assertSee('92.00%');
    }

    public function test_teacher_dashboard_shows_assigned_teaching_work_not_admin_registration_metrics(): void
    {
        $teacherUser = User::create([
            'name' => 'Dashboard Teacher',
            'email' => 'teacher.dashboard@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH902',
            'first_name' => 'Dashboard',
            'last_name' => 'Teacher',
            'status' => 'active',
        ]);
        $course = Course::create([
            'name' => 'Dashboard Biology',
            'code' => 'BIO902',
            'teacher_id' => $teacher->id,
            'status' => 'active',
        ]);
        $studentUser = User::create([
            'name' => 'Dashboard Student',
            'email' => 'student.dashboard@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'student_id' => 'STD902',
            'first_name' => 'Dashboard',
            'last_name' => 'Student',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Female',
            'status' => 'enrolled',
        ]);
        $course->students()->attach($student->id, ['status' => 'enrolled']);
        $assignment = Assignment::create([
            'course_id' => $course->id,
            'created_by' => $teacherUser->id,
            'title' => 'Biology Lab Report',
            'assignment_type' => 'file_upload',
            'status' => 'published',
            'due_date' => now()->addDays(2)->toDateString(),
            'ends_at' => now()->addDays(2),
        ]);
        AssignmentAttempt::create([
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
            'attempt_number' => 1,
            'started_at' => now(),
            'submitted_at' => now(),
            'file_name' => 'lab-report.pdf',
        ]);

        $this->actingAs($teacherUser)
            ->get(route('teacher.dashboard'))
            ->assertOk()
            ->assertSee('data-live-clock', false)
            ->assertSee('Assigned courses')
            ->assertSee('Students')
            ->assertSee('To grade')
            ->assertSee('Submissions this week')
            ->assertSee('Biology Lab Report')
            ->assertSee('Dashboard Biology')
            ->assertDontSee('New account registrations')
            ->assertDontSee('Total students');
    }

    public function test_teacher_calendar_shows_only_assigned_class_schedules_and_assignment_deadlines(): void
    {
        $teacherUser = User::create([
            'name' => 'Calendar Teacher',
            'email' => 'teacher.calendar@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH781',
            'first_name' => 'Calendar',
            'last_name' => 'Teacher',
            'status' => 'active',
        ]);
        $assignedCourse = Course::create([
            'name' => 'Assigned Calendar Course',
            'code' => 'CAL781',
            'teacher_id' => $teacher->id,
            'day_of_week' => 'Monday',
            'start_time' => '09:00',
            'end_time' => '10:30',
            'room' => 'Room 12',
            'status' => 'active',
        ]);
        $assignedCourse->assignments()->create([
            'title' => 'Assigned Calendar Deadline',
            'due_date' => '2026-10-15',
            'status' => 'published',
        ]);
        $unassignedCourse = Course::create([
            'name' => 'Unassigned Calendar Course',
            'code' => 'CAL782',
            'day_of_week' => 'Tuesday',
            'start_time' => '11:00',
            'end_time' => '12:00',
            'status' => 'active',
        ]);
        $unassignedCourse->assignments()->create([
            'title' => 'Unassigned Calendar Deadline',
            'due_date' => '2026-10-20',
            'status' => 'published',
        ]);

        $this->actingAs($teacherUser)
            ->get(route('teacher.calendar', ['month' => '2026-10']))
            ->assertOk()
            ->assertSee('Assigned Calendar Course')
            ->assertSee('Assigned Calendar Deadline')
            ->assertDontSee('Unassigned Calendar Course')
            ->assertDontSee('Unassigned Calendar Deadline');
    }

    public function test_teacher_report_summarizes_only_assigned_classes_and_exports_csv(): void
    {
        $teacherUser = User::create([
            'name' => 'Report Teacher',
            'email' => 'teacher.report@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'teacher_id' => 'TCH783',
            'first_name' => 'Report',
            'last_name' => 'Teacher',
            'status' => 'active',
        ]);
        $course = Course::create([
            'name' => 'Teacher Report Class',
            'code' => 'RPT783',
            'teacher_id' => $teacher->id,
            'status' => 'active',
        ]);
        $studentUsers = collect([
            ['Report Student One', 'report.student.one@example.test', 'STD783'],
            ['Report Student Two', 'report.student.two@example.test', 'STD784'],
        ])->map(function (array $details) {
            $user = User::create([
                'name' => $details[0],
                'email' => $details[1],
                'password' => 'password',
                'role' => 'student',
            ]);

            return Student::create([
                'user_id' => $user->id,
                'student_id' => $details[2],
                'first_name' => 'Report',
                'last_name' => 'Student',
                'date_of_birth' => '2005-01-01',
                'gender' => 'Female',
                'status' => 'enrolled',
            ]);
        });
        $course->students()->attach($studentUsers->pluck('id')->mapWithKeys(fn ($id) => [$id => ['status' => 'enrolled']])->all());
        foreach ($studentUsers as $index => $student) {
            \App\Models\Attendance::create([
                'course_id' => $course->id,
                'student_id' => $student->id,
                'attendance_date' => '2026-10-02',
                'status' => $index === 0 ? 'present' : 'absent',
                'marked_by' => $teacherUser->id,
            ]);
        }
        $course->assignments()->create([
            'title' => 'Teacher Report Assignment',
            'status' => 'published',
        ]);
        $unassignedCourse = Course::create([
            'name' => 'Another Teacher Class',
            'code' => 'RPT784',
            'status' => 'active',
        ]);
        $unassignedCourse->assignments()->create([
            'title' => 'Unassigned Report Assignment',
            'status' => 'published',
        ]);

        $this->actingAs($teacherUser)
            ->get(route('teacher.reports'))
            ->assertOk()
            ->assertSee('Teacher Report Class')
            ->assertSee('2 enrolled')
            ->assertSee('50%')
            ->assertSee('Assignments')
            ->assertDontSee('Another Teacher Class');

        $response = $this->get(route('teacher.reports.export'));
        $response->assertDownload('teacher-class-report-' . now()->format('Y-m-d') . '.csv');
        $csv = $response->streamedContent();
        $this->assertStringContainsString('"Teacher Report Class",RPT783,2,50%,1,1,1', $csv);
        $this->assertStringNotContainsString('Another Teacher Class', $csv);
        $this->assertStringNotContainsString('RPT784', $csv);

        $pdfResponse = $this->get(route('teacher.reports.export-pdf'));
        $pdfResponse->assertOk()->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF-', $pdfResponse->getContent());
    }

    public function test_admin_can_view_edit_and_delete_an_assignment(): void
    {
        $admin = $this->createAdmin();
        $course = Course::create([
            'name' => 'Data Structures',
            'code' => 'CS101',
            'status' => 'active',
        ]);
        $assignment = $course->assignments()->create([
            'title' => 'Linked List Project',
            'description' => 'Implement a linked list.',
            'due_date' => '2026-10-15',
            'status' => 'published',
            'created_by' => $admin->id,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.assignments.show', $assignment))
            ->assertOk()
            ->assertSee('Linked List Project')
            ->assertSee('CS101');

        $this->get(route('admin.assignments.edit', $assignment))
            ->assertOk()
            ->assertSee('description');

        $this->put(route('admin.assignments.update', $assignment), [
            'course_id' => $course->id,
            'title' => 'Updated List Project',
            'description' => 'Updated description.',
            'due_date' => '2026-10-20',
            'status' => 'draft',
        ])->assertRedirect(route('admin.assignments.show', $assignment));

        $this->assertDatabaseHas('assignments', [
            'id' => $assignment->id,
            'title' => 'Updated List Project',
            'status' => 'draft',
        ]);

        $this->delete(route('admin.assignments.destroy', $assignment))
            ->assertRedirect(route('admin.assignments'));

        $this->assertDatabaseMissing('assignments', ['id' => $assignment->id]);
    }

    public function test_admin_can_export_a_report_of_real_record_counts(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->get(route('admin.reports.export'))
            ->assertOk()
            ->assertDownload();
    }

    public function test_admin_can_export_report_as_pdf_and_dashboard_has_no_export_button(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('data-live-clock', false)
            ->assertSee('portal-profile-menu', false)
            ->assertSee('admin@example.test')
            ->assertSee('My Account')
            ->assertSee('Sign out')
            ->assertDontSee('Export report');

        $this->get(route('admin.reports'))
            ->assertOk()
            ->assertSee('Export Report')
            ->assertSee('Export as PDF');

        $this->get(route('admin.reports.export-pdf'))
            ->assertOk()
            ->assertDownload('slas-report-' . now()->format('Y-m-d') . '.pdf');
    }

    public function test_admin_can_create_a_student_and_login_account(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->post(route('admin.students.store'), [
                'student_id' => 'STD900',
                'first_name' => 'Nita',
                'last_name' => 'Chan',
                'email' => 'nita@example.test',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'date_of_birth' => '2005-04-12',
                'gender' => 'Female',
                'department' => 'Computer Science',
                'status' => 'enrolled',
            ])
            ->assertRedirect(route('admin.students'));

        $this->assertDatabaseHas('users', [
            'email' => 'nita@example.test',
            'role' => 'student',
        ]);
        $this->assertDatabaseHas('students', [
            'student_id' => 'STD900',
            'first_name' => 'Nita',
        ]);
    }

    public function test_admin_can_create_a_teacher_and_login_account(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->post(route('admin.teachers.store'), [
                'teacher_id' => 'TCH900',
                'first_name' => 'Dara',
                'last_name' => 'Sok',
                'email' => 'dara.teacher@example.test',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'department' => 'Computer Science',
                'status' => 'active',
            ])
            ->assertRedirect(route('admin.teachers'));

        $this->assertDatabaseHas('users', [
            'email' => 'dara.teacher@example.test',
            'role' => 'teacher',
        ]);
        $this->assertDatabaseHas('teachers', [
            'teacher_id' => 'TCH900',
            'first_name' => 'Dara',
        ]);
    }

    public function test_admin_can_view_update_and_delete_a_student(): void
    {
        $admin = $this->createAdmin();
        $user = User::create([
            'name' => 'Student One',
            'email' => 'student.one@example.test',
            'password' => 'password',
            'role' => 'student',
        ]);
        $student = Student::create([
            'user_id' => $user->id,
            'student_id' => 'STD901',
            'first_name' => 'Student',
            'last_name' => 'One',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Male',
            'status' => 'enrolled',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.students.show', $student))
            ->assertOk()
            ->assertSee('student.one@example.test');

        $this->put(route('admin.students.update', $student), [
            'student_id' => 'STD901',
            'first_name' => 'Updated',
            'last_name' => 'Student',
            'email' => 'student.updated@example.test',
            'date_of_birth' => '2005-01-01',
            'gender' => 'Male',
            'status' => 'enrolled',
        ])->assertRedirect(route('admin.students.show', $student));

        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => 'student.updated@example.test']);
        $this->assertDatabaseHas('students', ['id' => $student->id, 'first_name' => 'Updated']);

        $this->delete(route('admin.students.destroy', $student))
            ->assertRedirect(route('admin.students'));

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_can_view_update_and_delete_a_teacher(): void
    {
        $admin = $this->createAdmin();
        $user = User::create([
            'name' => 'Teacher One',
            'email' => 'teacher.one@example.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);
        $teacher = Teacher::create([
            'user_id' => $user->id,
            'teacher_id' => 'TCH901',
            'first_name' => 'Teacher',
            'last_name' => 'One',
            'status' => 'active',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.teachers.show', $teacher))
            ->assertOk()
            ->assertSee('teacher.one@example.test');

        $this->put(route('admin.teachers.update', $teacher), [
            'teacher_id' => 'TCH901',
            'first_name' => 'Updated',
            'last_name' => 'Teacher',
            'email' => 'teacher.updated@example.test',
            'status' => 'active',
        ])->assertRedirect(route('admin.teachers.show', $teacher));

        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => 'teacher.updated@example.test']);
        $this->assertDatabaseHas('teachers', ['id' => $teacher->id, 'first_name' => 'Updated']);

        $this->delete(route('admin.teachers.destroy', $teacher))
            ->assertRedirect(route('admin.teachers'));

        $this->assertDatabaseMissing('teachers', ['id' => $teacher->id]);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    private function createAdmin(): User
    {
        return User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]);
    }
}