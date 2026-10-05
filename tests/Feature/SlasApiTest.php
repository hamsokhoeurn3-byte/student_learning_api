<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\Department;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SlasApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_can_retrieve_departments_list(): void
    {
        $response = $this->getJson('/api/departments');

        $response->assertOk()
            ->assertJsonPath('message', 'Departments retrieved successfully.')
            ->assertJsonStructure(['data' => [['id', 'name', 'code']]]);
    }

    public function test_can_create_new_department(): void
    {
        $response = $this->postJson('/api/departments', [
            'name' => 'Cybersecurity & Infrastructure',
            'code' => 'CYBER',
            'description' => 'Cybersecurity department',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('message', 'Department created successfully.')
            ->assertJsonPath('data.code', 'CYBER');
    }

    public function test_can_retrieve_academic_years_and_semesters(): void
    {
        $responseYears = $this->getJson('/api/academic-years');
        $responseYears->assertOk();

        $responseSemesters = $this->getJson('/api/semesters');
        $responseSemesters->assertOk();
    }

    public function test_can_retrieve_courses_list(): void
    {
        $response = $this->getJson('/api/courses');

        $response->assertOk()
            ->assertJsonPath('message', 'Courses retrieved successfully.');
    }

    public function test_can_retrieve_students_list(): void
    {
        $response = $this->getJson('/api/students');

        $response->assertOk()
            ->assertJsonPath('message', 'Students retrieved successfully.');
    }

    public function test_can_retrieve_teachers_list(): void
    {
        $response = $this->getJson('/api/teachers');

        $response->assertOk()
            ->assertJsonPath('message', 'Teachers retrieved successfully.');
    }

    public function test_can_retrieve_learning_analytics(): void
    {
        $response = $this->getJson('/api/learning-analytics');

        $response->assertOk()
            ->assertJsonPath('message', 'Learning analytics retrieved successfully.');
    }

    public function test_can_retrieve_risk_assessments(): void
    {
        $response = $this->getJson('/api/risk-assessments');

        $response->assertOk()
            ->assertJsonPath('message', 'Risk assessments retrieved successfully.');
    }

    public function test_can_retrieve_predictions(): void
    {
        $response = $this->getJson('/api/predictions');

        $response->assertOk()
            ->assertJsonPath('message', 'Predictions retrieved successfully.');
    }

    public function test_student_dashboard_endpoint(): void
    {
        $studentUser = User::where('email', 'student@slas.com')->first();

        $response = $this->actingAs($studentUser)->getJson('/api/dashboard/student');

        $response->assertOk()
            ->assertJsonPath('message', 'Student dashboard retrieved successfully.');
    }

    public function test_teacher_dashboard_endpoint(): void
    {
        $teacherUser = User::where('email', 'teacher@slas.com')->first();

        $response = $this->actingAs($teacherUser)->getJson('/api/dashboard/teacher');

        $response->assertOk()
            ->assertJsonPath('message', 'Teacher dashboard retrieved successfully.');
    }

    public function test_admin_dashboard_endpoint(): void
    {
        $adminUser = User::where('email', 'admin@slas.com')->first();

        $response = $this->actingAs($adminUser)->getJson('/api/dashboard/admin');

        $response->assertOk()
            ->assertJsonPath('message', 'Admin dashboard retrieved successfully.');
    }
}
