<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_student_cannot_change_account_or_personal_fields_via_api(): void
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
            'phone' => '+855 99 999 999',
            'address' => 'Phnom Penh, Cambodia',
            'first_name' => 'Sok',
            'last_name' => 'Dara Updated',
            'department' => 'Information Technology',
        ]);

        $response
            ->assertUnprocessable()
            ->assertJsonPath('message', 'Students may only update their profile picture.');

        $studentUser = \App\Models\User::where('email', 'student@slas.com')->firstOrFail();

        $this->assertDatabaseHas('users', [
            'email' => 'student@slas.com',
            'name' => 'Sok Dara',
        ]);

        $this->assertDatabaseHas('students', [
            'user_id' => $studentUser->id,
            'first_name' => 'Sok',
            'last_name' => 'Dara',
            'phone' => null,
            'address' => null,
        ]);
    }

    public function test_authenticated_student_can_update_profile_picture_via_api(): void
    {
        $this->seed();
        Storage::fake('public');

        $login = $this->postJson('/api/login', [
            'login_id' => 'STD001',
            'password' => '12345678',
        ]);

        $token = $login->json('token');

        $response = $this->withToken($token)
            ->withHeaders(['Accept' => 'application/json'])
            ->post('/api/profile', [
                '_method' => 'PUT',
                'profile_picture' => UploadedFile::fake()->image('avatar.jpg', 200, 200),
            ]);

        $response
                ->assertOk()
            ->assertJsonPath('message', 'Profile picture updated successfully.');

        $this->assertNotNull($response->json('user.profile_picture'));

        $this->assertDatabaseHas('users', [
                'email' => 'student@slas.com',
        ]);
    }

    public function test_student_can_only_edit_profile_picture_in_profile_and_settings_pages(): void
    {
        $this->seed();
        $student = \App\Models\User::where('email', 'student@slas.com')->firstOrFail();

        $this->actingAs($student)
            ->get(route('student.profile.edit'))
            ->assertOk()
            ->assertSee('data-live-clock', false)
            ->assertSee('student-profile-menu', false)
            ->assertSee('student@slas.com')
            ->assertSee('Student ID: STD001')
            ->assertSee('My Account')
            ->assertSee('Sign out')
            ->assertDontSee('Logout')
            ->assertSee('name="profile_picture"', false)
            ->assertDontSee('name="name"', false)
            ->assertDontSee('name="email"', false)
            ->assertDontSee('name="phone"', false)
            ->assertDontSee('name="address"', false)
            ->assertDontSee('name="password"', false);

        $this->get(route('student.settings'))
            ->assertOk()
            ->assertSee('Student information')
            ->assertSee('Department')
            ->assertSee('Computer Science')
            ->assertSee('Academic year')
            ->assertSee('name="profile_picture"', false)
            ->assertDontSee('name="name"', false)
            ->assertDontSee('name="email"', false);
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
            'student_code' => 'STD500',
        ]);
    }
}

