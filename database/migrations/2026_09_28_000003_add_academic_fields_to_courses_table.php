<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (! Schema::hasColumn('courses', 'credits')) {
                $table->unsignedSmallInteger('credits')->nullable()->after('description');
            }
            if (! Schema::hasColumn('courses', 'teacher_id')) {
                $table->unsignedBigInteger('teacher_id')->nullable()->after('credits');
            }
            if (! Schema::hasColumn('courses', 'academic_year')) {
                $table->string('academic_year', 20)->nullable()->after('teacher_id');
            }
            if (! Schema::hasColumn('courses', 'semester')) {
                $table->string('semester', 50)->nullable()->after('academic_year');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['credits', 'teacher_id', 'academic_year', 'semester']);
        });
    }
};