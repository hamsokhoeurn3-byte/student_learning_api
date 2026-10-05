<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Derived, regenerable analytics data => FKs cascade.
        Schema::create('performance_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();

            // weekly | monthly | semester | yearly
            $table->string('period_type', 20)->default('semester');
            $table->date('period_start');
            $table->date('period_end');

            $table->decimal('attendance_percentage', 5, 2)->nullable();
            $table->decimal('assignment_percentage', 5, 2)->nullable();
            $table->decimal('quiz_percentage', 5, 2)->nullable();
            $table->decimal('exam_percentage', 5, 2)->nullable();
            $table->decimal('overall_score', 5, 2)->nullable();

            // excellent | good | average | poor
            $table->string('performance_level', 20)->nullable();

            $table->timestamps();

            $table->unique(
                ['student_id', 'course_id', 'period_type', 'period_start'],
                'performance_student_course_period_unique'
            );
            $table->index(['student_id', 'semester_id'], 'performance_student_semester_index');
            $table->index(['course_id', 'semester_id'], 'performance_course_semester_index');
            $table->index(['period_type', 'period_start'], 'performance_period_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_records');
    }
};
