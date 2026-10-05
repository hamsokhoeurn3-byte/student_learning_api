<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Aggregated per student across all courses for a period.
        Schema::create('learning_analytics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            // Nullable: a yearly analysis spans several semesters.
            $table->foreignId('semester_id')->nullable()->constrained('semesters')->cascadeOnDelete();

            // weekly | monthly | semester | yearly
            $table->string('period_type', 20)->default('semester');

            // Needed so weekly / monthly / yearly rows of the same student can be told apart.
            $table->date('period_start');
            $table->date('period_end');

            $table->decimal('attendance_rate', 5, 2)->nullable();
            $table->decimal('assignment_average', 5, 2)->nullable();
            $table->decimal('quiz_average', 5, 2)->nullable();
            $table->decimal('exam_average', 5, 2)->nullable();
            $table->decimal('overall_performance', 5, 2)->nullable();

            // Signed difference against the previous period (percentage points).
            $table->decimal('performance_change', 6, 2)->nullable();

            // improving | stable | declining
            $table->string('learning_trend', 20)->nullable();

            // JSON arrays of course/skill labels, e.g. ["Data Structures", "Quizzes"]
            $table->json('strengths')->nullable();
            $table->json('weaknesses')->nullable();

            $table->text('analytics_summary')->nullable();
            $table->dateTime('calculated_at');

            $table->timestamps();

            $table->unique(['student_id', 'period_type', 'period_start'], 'analytics_student_period_unique');
            $table->index(['student_id', 'semester_id'], 'analytics_student_semester_index');
            $table->index(['period_type', 'period_start'], 'analytics_period_index');
            $table->index('learning_trend');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_analytics');
    }
};
