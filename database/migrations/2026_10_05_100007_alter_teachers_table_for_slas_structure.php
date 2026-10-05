<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * ALTER teachers for the SLAS relational design.
 *
 *  - teachers.teacher_id (string login code) -> teachers.teacher_code
 *  - adds department_id (FK) and soft deletes
 *  - the free-text `department` is back-filled into departments / department_id
 *    and then dropped (no duplicated data).
 *  - kept as-is: first_name, last_name, date_of_birth, gender, position, specialization, status
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->renameColumn('teacher_id', 'teacher_code');
        });

        if (Schema::hasIndex('teachers', 'teachers_teacher_id_unique')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->renameIndex('teachers_teacher_id_unique', 'teachers_teacher_code_unique');
            });
        }

        Schema::table('teachers', function (Blueprint $table) {
            $table->foreignId('department_id')
                ->nullable()
                ->after('user_id')
                ->constrained('departments')
                ->restrictOnDelete();

            $table->softDeletes();

            $table->index('status', 'teachers_status_index');
        });

        if (Schema::hasColumn('teachers', 'department')) {
            $rows = DB::table('teachers')->whereNotNull('department')->get(['id', 'department']);

            foreach ($rows as $row) {
                if (blank($row->department)) {
                    continue;
                }

                DB::table('teachers')
                    ->where('id', $row->id)
                    ->update(['department_id' => $this->findOrCreateDepartmentId($row->department)]);
            }

            Schema::table('teachers', function (Blueprint $table) {
                $table->dropColumn('department');
            });
        }
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('department')->nullable();
        });

        $rows = DB::table('teachers')->whereNotNull('department_id')->get(['id', 'department_id']);

        foreach ($rows as $row) {
            DB::table('teachers')->where('id', $row->id)->update([
                'department' => DB::table('departments')->where('id', $row->department_id)->value('name'),
            ]);
        }

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropIndex('teachers_status_index');
            $table->dropForeign(['department_id']);
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('department_id');
            $table->dropSoftDeletes();
        });

        if (Schema::hasIndex('teachers', 'teachers_teacher_code_unique')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->renameIndex('teachers_teacher_code_unique', 'teachers_teacher_id_unique');
            });
        }

        Schema::table('teachers', function (Blueprint $table) {
            $table->renameColumn('teacher_code', 'teacher_id');
        });
    }

    private function findOrCreateDepartmentId(string $name): int
    {
        $name = trim($name);

        $existing = DB::table('departments')->whereRaw('LOWER(name) = ?', [mb_strtolower($name)])->value('id');

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

        return DB::table('departments')->insertGetId([
            'name' => $name,
            'code' => $code,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
