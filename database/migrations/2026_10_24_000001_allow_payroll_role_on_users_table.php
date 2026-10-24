<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The users.role column is a MySQL ENUM limited to student/teacher/admin.
 * Add the new 'payroll' staff role so payroll-panel accounts can sign in.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement(
            "ALTER TABLE users MODIFY role ENUM('student','teacher','admin','payroll') NOT NULL DEFAULT 'student'"
        );
    }

    public function down(): void
    {
        DB::statement(
            "UPDATE users SET role = 'admin' WHERE role = 'payroll'"
        );
        DB::statement(
            "ALTER TABLE users MODIFY role ENUM('student','teacher','admin') NOT NULL DEFAULT 'student'"
        );
    }
};
