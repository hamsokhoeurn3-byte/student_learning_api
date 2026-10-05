<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * ALTER students for the SLAS relational design.
 *
 *  - students.student_id (string login code)  -> students.student_code
 *    (frees the `student_id` name for foreign keys on child tables)
 *  - adds department_id (FK), class_id (FK) and soft deletes
 *  - replaces the free-text department / academic_year / semester columns
 *    with real relations. Existing values are BACK-FILLED into
 *    departments, academic_years, semesters and classes before the
 *    legacy columns are dropped, so no information is lost
 *    (the free-text `semester` has no per-student equivalent, it is kept
 *    as a semesters row of the student's academic year).
 *  - kept as-is: first_name, last_name, nationality, major, year_level, advisor, ...
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('student_id', 'student_code');
        });

        if (Schema::hasIndex('students', 'students_student_id_unique')) {
            Schema::table('students', function (Blueprint $table) {
                $table->renameIndex('students_student_id_unique', 'students_student_code_unique');
            });
        }

        Schema::table('students', function (Blueprint $table) {
            // Restrict: a department that still has students cannot be deleted.
            $table->foreignId('department_id')
                ->nullable()
                ->after('user_id')
                ->constrained('departments')
                ->restrictOnDelete();

            // A class can be removed without deleting its students.
            $table->foreignId('class_id')
                ->nullable()
                ->after('department_id')
                ->constrained('classes')
                ->nullOnDelete();

            // Students are academic history: deleting through the API is a soft delete.
            $table->softDeletes();

            $table->index('status', 'students_status_index');
        });

        $this->backfillAcademicRelations();

        Schema::table('students', function (Blueprint $table) {
            foreach (['department', 'academic_year', 'semester'] as $legacy) {
                if (Schema::hasColumn('students', $legacy)) {
                    $table->dropColumn($legacy);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('department')->nullable();
            $table->string('academic_year')->nullable();
            $table->string('semester')->nullable();
        });

        // Restore what can be restored from the relations.
        $students = DB::table('students')->get(['id', 'department_id', 'class_id']);

        foreach ($students as $student) {
            $department = $student->department_id
                ? DB::table('departments')->where('id', $student->department_id)->value('name')
                : null;

            $academicYear = $student->class_id
                ? DB::table('classes')
                    ->join('academic_years', 'academic_years.id', '=', 'classes.academic_year_id')
                    ->where('classes.id', $student->class_id)
                    ->value('academic_years.name')
                : null;

            DB::table('students')->where('id', $student->id)->update([
                'department' => $department,
                'academic_year' => $academicYear,
            ]);
        }

        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex('students_status_index');
            $table->dropForeign(['department_id']);
            $table->dropForeign(['class_id']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['department_id', 'class_id']);
            $table->dropSoftDeletes();
        });

        if (Schema::hasIndex('students', 'students_student_code_unique')) {
            Schema::table('students', function (Blueprint $table) {
                $table->renameIndex('students_student_code_unique', 'students_student_id_unique');
            });
        }

        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('student_code', 'student_id');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Back-fill helpers (self-contained: migrations must not depend on app code)
    |--------------------------------------------------------------------------
    */

    private function backfillAcademicRelations(): void
    {
        if (! Schema::hasColumn('students', 'department')) {
            return;
        }

        $rows = DB::table('students')->get(['id', 'department', 'academic_year', 'year_level', 'semester']);

        foreach ($rows as $row) {
            $department = filled($row->department) ? $this->findOrCreateDepartment($row->department) : null;
            $academicYear = filled($row->academic_year) ? $this->findOrCreateAcademicYear($row->academic_year) : null;

            if ($academicYear && filled($row->semester)) {
                $this->findOrCreateSemester($academicYear, $row->semester);
            }

            $level = (int) preg_replace('/\D/', '', (string) $row->year_level);
            $classId = null;

            if ($department && $academicYear && $level >= 1 && $level <= 9) {
                $classId = $this->findOrCreateClass($department, $academicYear, $level);
            }

            DB::table('students')->where('id', $row->id)->update([
                'department_id' => $department?->id,
                'class_id' => $classId,
            ]);
        }
    }

    private function findOrCreateDepartment(string $name): object
    {
        $name = trim($name);

        $existing = DB::table('departments')->whereRaw('LOWER(name) = ?', [mb_strtolower($name)])->first();

        if ($existing) {
            return $existing;
        }

        $words = preg_split('/\s+/', $name) ?: [$name];

        $code = count($words) > 1
            ? implode('', array_map(fn ($word) => mb_substr($word, 0, 1), $words))
            : mb_substr($name, 0, 4);

        $base = substr(strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $code)) ?: 'DEPT', 0, 12);
        $code = $base;
        $suffix = 2;

        while (DB::table('departments')->where('code', $code)->exists()) {
            $code = $base . $suffix++;
        }

        $id = DB::table('departments')->insertGetId([
            'name' => $name,
            'code' => $code,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return DB::table('departments')->find($id);
    }

    private function findOrCreateAcademicYear(string $name): object
    {
        $name = substr(trim($name), 0, 20);

        $existing = DB::table('academic_years')->where('name', $name)->first();

        if ($existing) {
            return $existing;
        }

        if (preg_match('/(\d{4})\D+(\d{4})/', $name, $matches)) {
            $start = "{$matches[1]}-09-01";
            $end = "{$matches[2]}-06-30";
        } else {
            $start = now()->year . '-09-01';
            $end = (now()->year + 1) . '-06-30';
        }

        $id = DB::table('academic_years')->insertGetId([
            'name' => $name,
            'start_date' => $start,
            'end_date' => $end,
            'status' => 'inactive',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return DB::table('academic_years')->find($id);
    }

    private function findOrCreateSemester(object $academicYear, string $name): void
    {
        $number = max(1, min(9, (int) preg_replace('/\D/', '', $name) ?: 1));

        $exists = DB::table('semesters')
            ->where('academic_year_id', $academicYear->id)
            ->where('semester_number', $number)
            ->exists();

        if ($exists) {
            return;
        }

        $yearStart = Carbon::parse($academicYear->start_date);
        $midpoint = $yearStart->copy()->addMonths(5);

        DB::table('semesters')->insert([
            'academic_year_id' => $academicYear->id,
            'name' => substr(trim($name), 0, 50),
            'semester_number' => $number,
            'start_date' => ($number === 1 ? $yearStart : $midpoint)->toDateString(),
            'end_date' => ($number === 1 ? $midpoint->copy()->subDay() : Carbon::parse($academicYear->end_date))->toDateString(),
            'status' => 'completed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function findOrCreateClass(object $department, object $academicYear, int $level): int
    {
        $code = substr("{$department->code}-Y{$level}-{$academicYear->name}", 0, 40);

        $existing = DB::table('classes')->where('code', $code)->value('id');

        if ($existing) {
            return $existing;
        }

        return DB::table('classes')->insertGetId([
            'department_id' => $department->id,
            'academic_year_id' => $academicYear->id,
            'name' => substr("{$department->name} Year {$level} ({$academicYear->name})", 0, 100),
            'code' => $code,
            'year_level' => $level,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
