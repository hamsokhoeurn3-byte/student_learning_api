<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->foreignId('semester_id')->nullable()->constrained('semesters')->nullOnDelete();

            // attendance | assignment | quiz | exam | gpa | study | general
            $table->string('type', 30)->default('general');

            $table->string('title', 200);
            $table->text('message');

            // low | medium | high
            $table->string('priority', 10)->default('medium');

            // pending | viewed | completed | dismissed
            $table->string('status', 20)->default('pending');

            // system | teacher | admin | ai
            $table->string('generated_by', 20)->default('system');

            $table->timestamps();

            $table->index(['student_id', 'status'], 'recommendations_student_status_index');
            $table->index('priority');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
