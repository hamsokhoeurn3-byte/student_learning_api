<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('quiz_attempt_id')->constrained('quiz_attempts')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('quiz_questions')->cascadeOnDelete();

            $table->text('answer')->nullable();

            // null = not graded yet (e.g. short_answer waiting for the teacher)
            $table->boolean('is_correct')->nullable();
            $table->decimal('marks_obtained', 5, 2)->nullable();

            $table->timestamps();

            $table->unique(['quiz_attempt_id', 'question_id'], 'quiz_answers_attempt_question_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_answers');
    }
};
