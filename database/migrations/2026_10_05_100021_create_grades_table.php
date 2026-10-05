<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // One row per student + course + semester. Component columns hold the
        // component percentage (0-100); total_score is the weighted result.
        Schema::create('grades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->restrictOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->restrictOnDelete();

            $table->decimal('assignment_score', 5, 2)->nullable();
            $table->decimal('quiz_score', 5, 2)->nullable();
            $table->decimal('attendance_score', 5, 2)->nullable();
            $table->decimal('midterm_score', 5, 2)->nullable();
            $table->decimal('final_exam_score', 5, 2)->nullable();
            $table->decimal('total_score', 5, 2)->nullable();

            $table->string('letter_grade', 3)->nullable();
            $table->decimal('grade_point', 3, 2)->nullable();

            // in_progress | final
            $table->string('status', 20)->default('in_progress');

            $table->timestamps();

            $table->unique(['student_id', 'course_id', 'semester_id'], 'grades_student_course_semester_unique');
            $table->index(['student_id', 'semester_id'], 'grades_student_semester_index');
            $table->index(['course_id', 'semester_id'], 'grades_course_semester_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
