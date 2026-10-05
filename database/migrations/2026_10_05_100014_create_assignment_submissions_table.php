<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            $table->dateTime('submitted_at')->nullable();
            $table->decimal('score', 6, 2)->nullable();
            $table->text('feedback')->nullable();

            // pending | submitted | late | graded
            $table->string('status', 20)->default('pending');

            $table->string('file_path', 500)->nullable();

            $table->timestamps();

            $table->unique(['assignment_id', 'student_id'], 'submissions_assignment_student_unique');
            $table->index(['student_id', 'status'], 'submissions_student_status_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};
