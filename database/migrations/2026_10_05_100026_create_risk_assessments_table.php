<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_assessments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            // NULL course_id = overall (semester-wide) risk for the student.
            $table->foreignId('course_id')->nullable()->constrained('courses')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();

            // low | medium | high
            $table->string('risk_level', 10);

            $table->decimal('risk_score', 5, 2);

            // JSON array of factor labels, e.g. ["Low attendance", "Declining performance"]
            $table->json('risk_factors')->nullable();

            $table->date('assessment_date');

            // open | monitoring | resolved
            $table->string('status', 20)->default('open');

            $table->timestamps();

            $table->index('risk_level');
            $table->index(['student_id', 'semester_id'], 'risk_student_semester_index');
            $table->index(['semester_id', 'risk_level'], 'risk_semester_level_index');
            $table->index('assessment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_assessments');
    }
};
