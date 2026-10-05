<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Stores the CALCULATED GPA; the service layer can recompute it from grades + course credits.
        Schema::create('gpa_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->restrictOnDelete();

            $table->decimal('gpa', 3, 2)->default(0);
            $table->decimal('total_credits', 5, 1)->default(0);
            $table->decimal('earned_credits', 5, 1)->default(0);

            // excellent | good | average | warning | probation
            $table->string('academic_standing', 20)->nullable();

            $table->timestamps();

            $table->unique(['student_id', 'semester_id'], 'gpa_records_student_semester_unique');
            $table->index('academic_standing');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gpa_records');
    }
};
