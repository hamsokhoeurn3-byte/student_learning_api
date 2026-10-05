<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Department;
use App\Models\Teacher;
use Database\Seeders\Support\DemoRoster;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::pluck('id', 'code');
        $teachers = Teacher::pluck('id', 'teacher_code');

        foreach (DemoRoster::courses() as $course) {
            Course::withTrashed()->updateOrCreate(
                ['course_code' => $course['code']],
                [
                    'department_id' => $departments[$course['dept']],
                    'teacher_id' => $teachers[$course['teacher']],
                    'course_name' => $course['name'],
                    'description' => $course['description'],
                    'credit' => $course['credit'],
                    'status' => 'active',
                    'deleted_at' => null,
                ]
            );
        }
    }
}