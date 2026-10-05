<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')->constrained('courses')->restrictOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->restrictOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->restrictOnDelete();

            $table->string('title', 200);

            // midterm | final | practical | other
            $table->string('exam_type', 20)->default('other');

            $table->date('exam_date');
            $table->decimal('total_score', 6, 2)->default(100);
            $table->unsignedSmallInteger('duration_minutes')->nullable();
            $table->text('description')->nullable();

            // scheduled | completed | cancelled
            $table->string('status', 20)->default('scheduled');

            $table->timestamps();

            $table->index('exam_date');
            $table->index(['course_id', 'semester_id', 'exam_type'], 'exams_course_semester_type_index');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
