<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Seed 300 additional students (with linked user accounts).
     * Safe to run once; re-running adds another 300 on top.
     */
    public function run(): void
    {
        $departments = [
            'Computer Science' => ['Software Engineering', 'Information Technology', 'Data Science'],
            'Business Administration' => ['Marketing', 'Finance', 'Human Resources'],
            'Engineering' => ['Civil Engineering', 'Electrical Engineering', 'Mechanical Engineering'],
            'Tourism and Hospitality' => ['Hotel Management', 'Tour Guiding'],
        ];

        $yearLevels = ['Year 1', 'Year 2', 'Year 3', 'Year 4'];
        $semesters = ['Semester 1', 'Semester 2'];
        $statuses = ['enrolled', 'enrolled', 'enrolled', 'enrolled', 'graduated', 'suspended'];
        $password = Hash::make('12345678');

        // Continue numbering after the highest existing STD number (e.g. STD001 -> starts at STD002).
        $lastNumber = (int) Student::query()
            ->selectRaw("MAX(CAST(SUBSTRING(student_id, 4) AS UNSIGNED)) as max_num")
            ->value('max_num');

        DB::transaction(function () use ($departments, $yearLevels, $semesters, $statuses, $password, $lastNumber) {
            for ($i = 1; $i <= 300; $i++) {
                $number = $lastNumber + $i;
                $studentId = 'STD' . str_pad((string) $number, 3, '0', STR_PAD_LEFT);

                $firstName = fake()->firstName();
                $lastName = fake()->lastName();
                $department = fake()->randomElement(array_keys($departments));
                $major = fake()->randomElement($departments[$department]);

                $user = User::create([
                    'name' => "{$firstName} {$lastName}",
                    'email' => 'student' . $number . '@slas.com',
                    'password' => $password,
                    'role' => 'student',
                ]);

                Student::create([
                    'user_id' => $user->id,
                    'student_id' => $studentId,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'date_of_birth' => fake()->dateTimeBetween('-26 years', '-18 years')->format('Y-m-d'),
                    'gender' => fake()->randomElement(['Male', 'Female']),
                    'nationality' => 'Cambodian',
                    'phone' => fake()->numerify('0##-###-###'),
                    'address' => fake()->city() . ', Cambodia',
                    'department' => $department,
                    'major' => $major,
                    'academic_year' => '2026-2027',
                    'year_level' => fake()->randomElement($yearLevels),
                    'semester' => fake()->randomElement($semesters),
                    'enrollment_date' => fake()->dateTimeBetween('-4 years', 'now')->format('Y-m-d'),
                    'status' => fake()->randomElement($statuses),
                ]);
            }
        });

        $this->command?->info('300 students seeded (' . 'STD' . str_pad((string) ($lastNumber + 1), 3, '0', STR_PAD_LEFT) . ' - STD' . str_pad((string) ($lastNumber + 300), 3, '0', STR_PAD_LEFT) . ').');
    }
}