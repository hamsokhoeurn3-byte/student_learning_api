<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A course is a catalogue entry. It is "offered" in a semester through
 * course_enrollments / attendance / assignments / quizzes / exams, which all
 * carry (course_id, semester_id). This lets the same course run in many
 * semesters without duplicating the course row.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('department_id')
                ->constrained('departments')
                ->restrictOnDelete();

            // Primary / coordinating teacher. Per-semester teachers are stored on the activity tables.
            $table->foreignId('teacher_id')
                ->nullable()
                ->constrained('teachers')
                ->nullOnDelete();

            $table->string('course_code', 30)->unique();
            $table->string('course_name', 150);
            $table->text('description')->nullable();
            $table->decimal('credit', 3, 1)->default(3.0);

            // active | inactive | archived
            $table->string('status', 20)->default('active');

            $table->timestamps();
            $table->softDeletes();

            $table->index('course_name');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
