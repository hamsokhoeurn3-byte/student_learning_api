<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            // Nullable so future non-course predictions (e.g. GPA) fit without a schema change.
            $table->foreignId('course_id')->nullable()->constrained('courses')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();

            // exam_score | final_score | course_performance
            $table->string('prediction_type', 30);

            $table->decimal('predicted_score', 6, 2);

            // 0.0000 - 1.0000
            $table->decimal('confidence_score', 5, 4)->nullable();

            $table->date('prediction_date');

            // Identifies the model / algorithm that produced the row (future ML integration).
            $table->string('model_version', 50)->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['student_id', 'semester_id'], 'predictions_student_semester_index');
            $table->index(['student_id', 'course_id'], 'predictions_student_course_index');
            $table->index('prediction_date');
            $table->index('prediction_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
