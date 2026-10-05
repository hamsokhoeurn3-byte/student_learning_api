<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            // Defaults to 1 so the quiz_id + student_id rule from the spec (one attempt)
            // is enforced today, but retakes only need attempt_number > 1 later - no schema change.
            $table->unsignedTinyInteger('attempt_number')->default(1);

            $table->dateTime('started_at');
            $table->dateTime('submitted_at')->nullable();
            $table->decimal('score', 6, 2)->nullable();

            // in_progress | submitted | graded
            $table->string('status', 20)->default('in_progress');

            $table->timestamps();

            $table->unique(['quiz_id', 'student_id', 'attempt_number'], 'quiz_attempts_quiz_student_attempt_unique');
            $table->index(['student_id', 'status'], 'quiz_attempts_student_status_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
