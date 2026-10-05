<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\ClassRoom;
use App\Models\Department;
use App\Models\Semester;
use Database\Seeders\Support\DemoRoster;
use Illuminate\Database\Seeder;

/**
 * Departments, academic years, semesters and classes.
 * Idempotent: rows are matched on their natural unique keys.
 */
class AcademicStructureSeeder extends Seeder
{
    public function run(): void
    {
        foreach (DemoRoster::departments() as $department) {
            Department::updateOrCreate(
                ['code' => $department['code']],
                ['name' => $department['name'], 'description' => $department['description'], 'status' => 'active']
            );
        }

        $years = [
            ['name' => '2025-2026', 'start' => '2025-09-01', 'end' => '2026-06-30', 'status' => 'completed'],
            ['name' => '2026-2027', 'start' => '2026-09-01', 'end' => '2027-06-30', 'status' => 'active'],
        ];

        $semesters = [
            '2025-2026' => [
                [1, 'Semester 1', '2025-09-01', '2026-01-31', 'completed'],
                [2, 'Semester 2', '2026-02-01', '2026-06-30', 'completed'],
            ],
            '2026-2027' => [
                [1, 'Semester 1', '2026-09-01', '2027-01-31', 'active'],
                [2, 'Semester 2', '2027-02-01', '2027-06-30', 'upcoming'],
            ],
        ];

        foreach ($years as $year) {
            $academicYear = AcademicYear::updateOrCreate(
                ['name' => $year['name']],
                ['start_date' => $year['start'], 'end_date' => $year['end'], 'status' => $year['status']]
            );

            foreach ($semesters[$year['name']] as [$number, $name, $start, $end, $status]) {
                Semester::updateOrCreate(
                    ['academic_year_id' => $academicYear->id, 'semester_number' => $number],
                    ['name' => $name, 'start_date' => $start, 'end_date' => $end, 'status' => $status]
                );
            }
        }

        // Year 1-3 classes of every department for the active academic year.
        $active = AcademicYear::where('name', '2026-2027')->firstOrFail();

        foreach (Department::all() as $department) {
            foreach ([1, 2, 3] as $level) {
                ClassRoom::updateOrCreate(
                    ['code' => "{$department->code}-Y{$level}-{$active->name}"],
                    [
                        'department_id' => $department->id,
                        'academic_year_id' => $active->id,
                        'name' => "{$department->name} Year {$level} ({$active->name})",
                        'year_level' => $level,
                        'status' => 'active',
                    ]
                );
            }
        }
    }
}
