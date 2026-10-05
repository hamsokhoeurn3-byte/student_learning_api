<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_enrollments', function (Blueprint $table) {
            $table->id();

            // Child of the student: removed only when a student is force-deleted.
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            // Academic history: courses / semesters with enrollments cannot be deleted.
            $table->foreignId('course_id')->constrained('courses')->restrictOnDelete();
            $table->foreignId('semester_id')->nullable()->constrained('semesters')->restrictOnDelete();

            $table->date('enrollment_date')->nullable();

            // enrolled | completed | dropped | failed
            $table->string('status', 20)->default('enrolled');

            $table->decimal('final_score', 5, 2)->nullable();
            $table->string('grade', 3)->nullable();

            $table->timestamps();

            $table->unique(['student_id', 'course_id', 'semester_id'], 'enrollments_student_course_semester_unique');
            $table->index(['student_id', 'semester_id'], 'enrollments_student_semester_index');
            $table->index(['course_id', 'semester_id'], 'enrollments_course_semester_index');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_enrollments');
    }
};
