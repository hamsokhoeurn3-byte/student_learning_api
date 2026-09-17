<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_login_with_student_id_via_api(): void
    {
        $this->seed();

        $response = $this->postJson('/api/login', [
            'login_id' => 'STD001',
            'password' => '12345678',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('message', 'Login successful.')
            ->assertJsonPath('user.role', 'student');

        $this->assertNotEmpty($response->json('token'));
    }

    public function test_invalid_credentials_are_rejected_by_api(): void
    {
        $this->seed();

        $response = $this->postJson('/api/login', [
            'login_id' => 'STD001',
            'password' => 'wrong-password',
        ]);

        $response
            ->assertStatus(401)
            ->assertJsonPath('message', 'Invalid credentials.');
    }

    public function test_student_can_register_via_api(): void
    {
        $response = $this->postJson('/api/register', [
            'student_id' => 'STD999',
            'first_name' => 'Test',
            'last_name' => 'Student',
            'email' => 'student999@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'date_of_birth' => '2005-01-15',
            'gender' => 'Male',
            'department' => 'Computer Science',
            'major' => 'Software Engineering',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonPath('message', 'Registration successful.')
            ->assertJsonPath('user.role', 'student');

        $this->assertNotEmpty($response->json('token'));
    }

    public function test_authenticated_student_can_update_profile_via_api(): void
    {
        $this->seed();

        $login = $this->postJson('/api/login', [
            'login_id' => 'STD001',
            'password' => '12345678',
        ]);

        $token = $login->json('token');

        $response = $this->withToken($token)->putJson('/api/profile', [
            'name' => 'Sok Dara Updated',
            'email' => 'student.updated@slas.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
            'first_name' => 'Sok',
            'last_name' => 'Dara Updated',
            'department' => 'Information Technology',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('message', 'Profile updated successfully.')
            ->assertJsonPath('user.name', 'Sok Dara Updated');

        $this->assertDatabaseHas('users', [
            'email' => 'student.updated@slas.com',
        ]);
    }

    public function test_authenticated_student_can_update_profile_picture_via_api(): void
    {
        $this->seed();

        $login = $this->postJson('/api/login', [
            'login_id' => 'STD001',
            'password' => '12345678',
        ]);

        $token = $login->json('token');

        $response = $this->withToken($token)
            ->withHeaders(['Accept' => 'application/json'])
            ->post('/api/profile', [
                '_method' => 'PUT',
                'name' => 'Sok Dara',
                'email' => 'student.profile@slas.com',
                'first_name' => 'Sok',
                'last_name' => 'Dara',
                'profile_picture' => UploadedFile::fake()->image('avatar.jpg', 200, 200),
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('message', 'Profile updated successfully.');

        $this->assertNotNull($response->json('user.profile_picture'));

        $this->assertDatabaseHas('users', [
            'email' => 'student.profile@slas.com',
        ]);
    }

    public function test_student_record_can_be_created_via_students_api(): void
    {
        $response = $this->postJson('/api/students', [
            'student_id' => 'STD500',
            'first_name' => 'New',
            'last_name' => 'Student',
            'email' => 'newstudent@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'date_of_birth' => '2005-02-14',
            'gender' => 'Female',
            'department' => 'Computer Science',
            'major' => 'Software Engineering',
            'academic_year' => '2026-2027',
            'year_level' => 2,
            'semester' => 'Semester 1',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonPath('message', 'Student created successfully.')
            ->assertJsonPath('data.student_id', 'STD500');

        $this->assertDatabaseHas('students', [
            'student_id' => 'STD500',
        ]);
    }
}
