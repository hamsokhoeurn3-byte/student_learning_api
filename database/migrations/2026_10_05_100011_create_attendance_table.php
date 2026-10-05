<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // One row = one class meeting / attendance session.
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')->constrained('courses')->restrictOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->restrictOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->restrictOnDelete();

            $table->date('attendance_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('topic', 255)->nullable();

            // scheduled | completed | cancelled
            $table->string('status', 20)->default('scheduled');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('attendance_date');
            $table->index(['course_id', 'semester_id', 'attendance_date'], 'attendance_course_semester_date_index');
            $table->index(['teacher_id', 'attendance_date'], 'attendance_teacher_date_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
