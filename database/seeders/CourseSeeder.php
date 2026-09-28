<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['CS101', 'Introduction to Programming', 'Fundamentals of programming using PHP and Python.', 'Computer Science', 3, 1, '2026-2027', 'Semester 1'],
            ['CS201', 'Data Structures', 'Arrays, linked lists, stacks, queues, trees and graphs.', 'Computer Science', 3, 1, '2026-2027', 'Semester 1'],
            ['CS301', 'Database Systems', 'Relational design, SQL, normalization and transactions.', 'Computer Science', 3, 1, '2026-2027', 'Semester 2'],
            ['CS305', 'Web Application Development', 'Building full-stack apps with Laravel.', 'Computer Science', 4, 1, '2026-2027', 'Semester 2'],
            ['BA101', 'Principles of Management', 'Core concepts of planning, organizing and leading.', 'Business Administration', 3, null, '2026-2027', 'Semester 1'],
            ['BA210', 'Marketing Fundamentals', 'Market research, branding and consumer behavior.', 'Business Administration', 3, null, '2026-2027', 'Semester 2'],
            ['EN101', 'Engineering Mathematics', 'Calculus and linear algebra for engineers.', 'Engineering', 4, null, '2026-2027', 'Semester 1'],
            ['TH101', 'Introduction to Hospitality', 'Overview of the tourism and hotel industry in Cambodia.', 'Tourism and Hospitality', 3, null, '2026-2027', 'Semester 1'],
        ];

        foreach ($courses as [$code, $name, $description, $department, $credits, $teacherId, $academicYear, $semester]) {
            Course::updateOrCreate(
                ['code' => $code],
                [
                    'name' => $name,
                    'description' => $description,
                    'department' => $department,
                    'credits' => $credits,
                    'teacher_id' => $teacherId,
                    'academic_year' => $academicYear,
                    'semester' => $semester,
                    'status' => 'active',
                ]
            );
        }
    }
}