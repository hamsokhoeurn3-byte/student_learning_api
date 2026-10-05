<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\ClassRoom;
use App\Models\Department;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Database\Seeders\Support\DemoRoster;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Demo login accounts. The three original accounts (student@slas.com,
 * teacher@slas.com, admin@slas.com with password 12345678) are preserved.
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make(DemoRoster::PASSWORD);

        $departments = Department::pluck('id', 'code');

        // Admin -------------------------------------------------------------
        $a = DemoRoster::admin();

        $adminUser = User::updateOrCreate(
            ['email' => $a['email']],
            ['name' => $a['name'], 'password' => $password, 'role' => 'admin', 'status' => 'active']
        );

        Admin::updateOrCreate(
            ['user_id' => $adminUser->id],
            [
                'admin_code' => $a['admin_code'],
                'first_name' => $a['first_name'],
                'last_name' => $a['last_name'],
                'department' => $a['department'],
                'position' => $a['position'],
                'status' => 'active',
            ]
        );

        // Teachers ----------------------------------------------------------
        foreach (DemoRoster::teachers() as $t) {
            $user = User::updateOrCreate(
                ['email' => $t['email']],
                ['name' => "{$t['first']} {$t['last']}", 'password' => $password, 'role' => 'teacher', 'status' => 'active']
            );

            Teacher::withTrashed()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'teacher_code' => $t['code'],
                    'department_id' => $departments[$t['dept']],
                    'first_name' => $t['first'],
                    'last_name' => $t['last'],
                    'gender' => $t['gender'],
                    'position' => $t['position'],
                    'specialization' => $t['specialization'],
                    'status' => 'active',
                    'deleted_at' => null,
                ]
            );
        }

        // Students ----------------------------------------------------------
        foreach (DemoRoster::students() as $s) {
            $user = User::updateOrCreate(
                ['email' => $s['email']],
                ['name' => "{$s['first']} {$s['last']}", 'password' => $password, 'role' => 'student', 'status' => 'active']
            );

            $classId = ClassRoom::where('code', "{$s['dept']}-Y{$s['level']}-2026-2027")->value('id');

            Student::withTrashed()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'student_code' => $s['code'],
                    'department_id' => $departments[$s['dept']],
                    'class_id' => $classId,
                    'first_name' => $s['first'],
                    'last_name' => $s['last'],
                    'date_of_birth' => $s['dob'],
                    'gender' => $s['gender'],
                    'nationality' => 'Cambodian',
                    'major' => $s['major'],
                    'year_level' => 'Year ' . $s['level'],
                    'enrollment_date' => (2026 - $s['level'] + 1) . '-09-01',
                    'status' => 'enrolled',
                    'deleted_at' => null,
                ]
            );
        }
    }
}
