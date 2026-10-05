<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();

            $table->text('question_text');

            // multiple_choice | true_false | short_answer
            $table->string('question_type', 30)->default('multiple_choice');

            $table->decimal('marks', 5, 2)->default(1);
            $table->unsignedSmallInteger('question_order')->default(1);

            // Flat option columns are the simplest shape for Gson / Retrofit models.
            // true_false and short_answer questions leave them null.
            $table->string('option_a', 500)->nullable();
            $table->string('option_b', 500)->nullable();
            $table->string('option_c', 500)->nullable();
            $table->string('option_d', 500)->nullable();

            // multiple_choice => "A".."D", true_false => "true"/"false", short_answer => expected text
            $table->string('correct_answer', 500)->nullable();

            $table->timestamps();

            $table->unique(['quiz_id', 'question_order'], 'quiz_questions_quiz_order_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
