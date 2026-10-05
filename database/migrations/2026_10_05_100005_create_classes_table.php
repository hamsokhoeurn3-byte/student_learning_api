<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('classes')) {
            Schema::create('classes', function (Blueprint $table) {
                $table->id();

                $table->foreignId('department_id')
                    ->nullable()
                    ->constrained('departments')
                    ->nullOnDelete();

                $table->foreignId('academic_year_id')
                    ->nullable()
                    ->constrained('academic_years')
                    ->nullOnDelete();

                $table->foreignId('course_id')
                    ->nullable()
                    ->constrained('courses')
                    ->nullOnDelete();

                $table->foreignId('teacher_id')
                    ->nullable()
                    ->constrained('teachers')
                    ->nullOnDelete();

                $table->string('name', 100);
                $table->string('code', 40)->unique();

                $table->unsignedTinyInteger('year_level')->nullable();

                $table->string('day_of_week')->nullable();
                $table->time('start_time')->nullable();
                $table->time('end_time')->nullable();
                $table->string('room')->nullable();

                $table->string('status', 20)->default('active');

                $table->timestamps();

                $table->index(['department_id', 'academic_year_id'], 'classes_department_year_index');
                $table->index('year_level');
                $table->index('status');
            });
        } else {
            Schema::table('classes', function (Blueprint $table) {
                if (! Schema::hasColumn('classes', 'department_id')) {
                    $table->foreignId('department_id')
                        ->nullable()
                        ->after('id')
                        ->constrained('departments')
                        ->nullOnDelete();
                }

                if (! Schema::hasColumn('classes', 'academic_year_id')) {
                    $table->foreignId('academic_year_id')
                        ->nullable()
                        ->after('department_id')
                        ->constrained('academic_years')
                        ->nullOnDelete();
                }

                if (! Schema::hasColumn('classes', 'year_level')) {
                    $table->unsignedTinyInteger('year_level')
                        ->nullable()
                        ->after('code');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
