<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // A report record is kept even if its subject is removed.
            $table->foreignId('student_id')->nullable()->constrained('students')->nullOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->foreignId('semester_id')->nullable()->constrained('semesters')->nullOnDelete();

            // student_performance | attendance | assignment | quiz | gpa | semester
            // | learning_analytics | prediction | risk
            $table->string('report_type', 30);

            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->string('file_path', 500)->nullable();

            // The user (admin / teacher / student) who requested it; NULL = system generated.
            $table->foreignId('generated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('generated_at')->nullable();

            // pending | generated | failed
            $table->string('status', 20)->default('pending');

            $table->timestamps();

            $table->index('report_type');
            $table->index(['student_id', 'report_type'], 'reports_student_type_index');
            $table->index(['teacher_id', 'report_type'], 'reports_teacher_type_index');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
