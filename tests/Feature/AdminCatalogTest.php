<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
                'status' => 'active',
            ])
            ->assertRedirect(route('admin.courses'));

        $this->assertDatabaseHas('courses', [
            'name' => 'Data Structures',
            'code' => 'CS101',
        ]);

        $this->get(route('admin.courses'))
            ->assertOk()
            ->assertSee('Data Structures')
            ->assertSee('CS101');
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
            ->assertSee('CS777');

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