<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = Hash::make('12345678');

        $studentUser = User::updateOrCreate(
            ['email' => 'student@slas.com'],
            ['name' => 'Sok Dara', 'password' => $password, 'role' => 'student']
        );

        Student::updateOrCreate(
            ['user_id' => $studentUser->id],
            [
                'student_id' => 'STD001',
                'first_name' => 'Sok',
                'last_name' => 'Dara',
                'date_of_birth' => '2004-05-14',
                'gender' => 'Male',
                'department' => 'Computer Science',
                'major' => 'Software Engineering',
                'academic_year' => '2026-2027',
                'year_level' => 'Year 3',
                'semester' => 'Semester 1',
            ]
        );

        $teacherUser = User::updateOrCreate(
            ['email' => 'teacher@slas.com'],
            ['name' => 'Emily Johnson', 'password' => $password, 'role' => 'teacher']
        );

        Teacher::updateOrCreate(
            ['user_id' => $teacherUser->id],
            [
                'teacher_id' => 'TCH001',
                'first_name' => 'Emily',
                'last_name' => 'Johnson',
                'department' => 'Computer Science',
                'position' => 'Lecturer',
                'specialization' => 'Data Structures',
                'status' => 'active',
            ]
        );

        $adminUser = User::updateOrCreate(
            ['email' => 'admin@slas.com'],
            ['name' => 'Admin SLAS', 'password' => $password, 'role' => 'admin']
        );

        Admin::updateOrCreate(
            ['user_id' => $adminUser->id],
            [
                'admin_id' => 'ADM001',
                'first_name' => 'SLAS',
                'last_name' => 'Administrator',
                'department' => 'Administration',
                'position' => 'System Administrator',
                'status' => 'active',
            ]
        );
    }
}
