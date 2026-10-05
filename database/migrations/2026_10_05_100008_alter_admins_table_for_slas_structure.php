<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ALTER admins: only the login code column is renamed (admin_id -> admin_code)
 * so it follows the same naming convention as student_code / teacher_code.
 * The free-text department/position columns of admins are administrative
 * labels (not academic structure) and are intentionally preserved.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->renameColumn('admin_id', 'admin_code');
        });

        if (Schema::hasIndex('admins', 'admins_admin_id_unique')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->renameIndex('admins_admin_id_unique', 'admins_admin_code_unique');
            });
        }

        Schema::table('admins', function (Blueprint $table) {
            $table->index('status', 'admins_status_index');
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropIndex('admins_status_index');
        });

        if (Schema::hasIndex('admins', 'admins_admin_code_unique')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->renameIndex('admins_admin_code_unique', 'admins_admin_id_unique');
            });
        }

        Schema::table('admins', function (Blueprint $table) {
            $table->renameColumn('admin_code', 'admin_id');
        });
    }
};
