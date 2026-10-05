<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('assignments')) {
            Schema::create('assignments', function (Blueprint $table) {
                $table->id();

                $table->foreignId('course_id')->constrained('courses')->restrictOnDelete();
                $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
                $table->foreignId('semester_id')->nullable()->constrained('semesters')->nullOnDelete();

                $table->string('title', 200);
                $table->text('description')->nullable();
                $table->decimal('total_score', 6, 2)->default(100);
                $table->dateTime('due_date')->nullable();

                // draft | published | closed
                $table->string('status', 20)->default('draft');

                $table->timestamps();

                $table->index('due_date');
                $table->index('status');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
