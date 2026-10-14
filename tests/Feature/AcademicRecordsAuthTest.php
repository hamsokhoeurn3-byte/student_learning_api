<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Grade;
use App\Models\GpaRecord;
use App\Models\PerformanceRecord;
use App\Models\Semester;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicRecordsAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUpData()
    {
        $academicYear = \App\Models\AcademicYear::create(['name' => '2026-2027', 'start_date' => '2026-09-01', 'end_date' => '2027-06-30']);

        $this->course = Course::create(['name' => 'Math', 'code' => 'M101', 'status' => 'active']);
        $this->semester = Semester::create(['name' => 'Fall 2026', 'academic_year_id' => $academicYear->id, 'semester_number' => 1, 'start_date' => '2026-09-01', 'end_date' => '2026-12-15']);

        $this->studentUser1 = User::create(['name' => 'S1', 'email' => 's1@test.com', 'password' => 'pwd', 'role' => 'student']);
        $this->student1 = Student::create(['user_id' => $this->studentUser1->id, 'student_id' => 'STD01', 'first_name' => 'S1', 'last_name' => 'L', 'date_of_birth' => '2000-01-01', 'gender' => 'Male']);

        $this->studentUser2 = User::create(['name' => 'S2', 'email' => 's2@test.com', 'password' => 'pwd', 'role' => 'student']);
        $this->student2 = Student::create(['user_id' => $this->studentUser2->id, 'student_id' => 'STD02', 'first_name' => 'S2', 'last_name' => 'L', 'date_of_birth' => '2000-01-01', 'gender' => 'Female']);

        $this->teacherUser = User::create(['name' => 'T1', 'email' => 't1@test.com', 'password' => 'pwd', 'role' => 'teacher']);
        $this->adminUser = User::create(['name' => 'A1', 'email' => 'a1@test.com', 'password' => 'pwd', 'role' => 'admin']);

        $this->missingProfileUser = User::create(['name' => 'S3', 'email' => 's3@test.com', 'password' => 'pwd', 'role' => 'student']);
    }

    public function test_unauthenticated_cannot_access_grades()
    {
        $response = $this->getJson('/api/grades');
        $response->assertStatus(401);
    }

    public function test_unauthenticated_cannot_access_endpoints()
    {
        $this->getJson('/api/gpa-records')->assertStatus(401);
        $this->getJson('/api/performance-records')->assertStatus(401);
    }

    public function test_student_can_only_access_their_own_grades()
    {
        $this->setUpData();

        $grade1 = Grade::create(['student_id' => $this->student1->id, 'course_id' => $this->course->id, 'semester_id' => $this->semester->id, 'assignment_score' => 90]);
        $grade2 = Grade::create(['student_id' => $this->student2->id, 'course_id' => $this->course->id, 'semester_id' => $this->semester->id, 'assignment_score' => 80]);

        $response = $this->actingAs($this->studentUser1)->getJson('/api/grades');

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $this->assertEquals($this->student1->id, $response->json('data.0.student_id'));

        $response2 = $this->actingAs($this->studentUser1)->getJson('/api/grades?student_id=' . $this->student2->id);
        $response2->assertOk();
        $response2->assertJsonCount(1, 'data'); // Returns their own grade, ignores the query parameter
        $this->assertEquals($this->student1->id, $response2->json('data.0.student_id'));

        $this->actingAs($this->studentUser1)->getJson('/api/grades/' . $grade1->id)->assertOk();
        $this->actingAs($this->studentUser1)->getJson('/api/grades/' . $grade2->id)->assertStatus(403);
    }

    public function test_student_can_only_access_their_own_records()
    {
        $this->setUpData();

        $gpa1 = GpaRecord::create(['student_id' => $this->student1->id, 'semester_id' => $this->semester->id, 'gpa' => 3.5, 'total_credits' => 30, 'earned_credits' => 30]);
        $gpa2 = GpaRecord::create(['student_id' => $this->student2->id, 'semester_id' => $this->semester->id, 'gpa' => 3.0, 'total_credits' => 30, 'earned_credits' => 30]);

        $perf1 = PerformanceRecord::create(['student_id' => $this->student1->id, 'course_id' => $this->course->id, 'semester_id' => $this->semester->id, 'period_start' => '2026-09-01', 'period_end' => '2026-10-01']);
        $perf2 = PerformanceRecord::create(['student_id' => $this->student2->id, 'course_id' => $this->course->id, 'semester_id' => $this->semester->id, 'period_start' => '2026-09-01', 'period_end' => '2026-10-01']);

        // GPA
        $this->actingAs($this->studentUser1)->getJson('/api/gpa-records')
            ->assertOk()->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.student_id', $this->student1->id);
        $this->actingAs($this->studentUser1)->getJson('/api/gpa-records/' . $gpa1->id)->assertOk();
        $this->actingAs($this->studentUser1)->getJson('/api/gpa-records/' . $gpa2->id)->assertStatus(403);

        // Performance
        $this->actingAs($this->studentUser1)->getJson('/api/performance-records')
            ->assertOk()->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.student_id', $this->student1->id);
        $this->actingAs($this->studentUser1)->getJson('/api/performance-records/' . $perf1->id)->assertOk();
        $this->actingAs($this->studentUser1)->getJson('/api/performance-records/' . $perf2->id)->assertStatus(403);
    }

    public function test_student_cannot_create_grade()
    {
        $this->setUpData();

        $response = $this->actingAs($this->studentUser1)->postJson('/api/grades', [
            'student_id' => $this->student1->id,
            'course_id' => $this->course->id,
            'semester_id' => $this->semester->id,
            'assignment_score' => 100,
        ]);

        $response->assertStatus(403);
    }

    public function test_student_cannot_write_records()
    {
        $this->setUpData();

        $gpaData = ['student_id' => $this->student1->id, 'semester_id' => $this->semester->id, 'gpa' => 4.0, 'total_credits' => 30, 'earned_credits' => 30];
        $this->actingAs($this->studentUser1)->postJson('/api/gpa-records', $gpaData)->assertStatus(403);

        $perfData = ['student_id' => $this->student1->id, 'course_id' => $this->course->id, 'semester_id' => $this->semester->id, 'period_start' => '2026-09-01', 'period_end' => '2026-10-01'];
        $this->actingAs($this->studentUser1)->postJson('/api/performance-records', $perfData)->assertStatus(403);
    }

    public function test_student_missing_profile_handled_gracefully()
    {
        $this->setUpData();

        $this->actingAs($this->missingProfileUser)->getJson('/api/grades')->assertStatus(404);
        $this->actingAs($this->missingProfileUser)->getJson('/api/gpa-records')->assertStatus(404);
        $this->actingAs($this->missingProfileUser)->getJson('/api/performance-records')->assertStatus(404);
    }

    public function test_teacher_can_create_and_view_grades()
    {
        $this->setUpData();

        $response = $this->actingAs($this->teacherUser)->postJson('/api/grades', [
            'student_id' => $this->student1->id,
            'course_id' => $this->course->id,
            'semester_id' => $this->semester->id,
            'assignment_score' => 100,
        ]);

        $response->assertStatus(201);

        $response2 = $this->actingAs($this->teacherUser)->getJson('/api/grades');
        $response2->assertOk();
        $response2->assertJsonCount(1, 'data');
    }

    public function test_teacher_can_manage_records()
    {
        $this->setUpData();

        $gpaData = ['student_id' => $this->student1->id, 'semester_id' => $this->semester->id, 'gpa' => 3.8, 'total_credits' => 30, 'earned_credits' => 30];
        $this->actingAs($this->teacherUser)->postJson('/api/gpa-records', $gpaData)->assertStatus(201);

        $perfData = ['student_id' => $this->student1->id, 'course_id' => $this->course->id, 'semester_id' => $this->semester->id, 'period_start' => '2026-09-01', 'period_end' => '2026-10-01'];
        $this->actingAs($this->teacherUser)->postJson('/api/performance-records', $perfData)->assertStatus(201);
    }

    public function test_admin_can_manage_records()
    {
        $this->setUpData();

        $gradeData = ['student_id' => $this->student1->id, 'course_id' => $this->course->id, 'semester_id' => $this->semester->id, 'assignment_score' => 100];
        $this->actingAs($this->adminUser)->postJson('/api/grades', $gradeData)->assertStatus(201);
        $this->actingAs($this->adminUser)->getJson('/api/grades')->assertOk()->assertJsonCount(1, 'data');
    }
}
