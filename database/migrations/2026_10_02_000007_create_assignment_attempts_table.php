<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('assignment_attempts')) {
            Schema::create('assignment_attempts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('assignment_id');
                $table->unsignedBigInteger('student_id');
                $table->unsignedSmallInteger('attempt_number');
                $table->timestamp('started_at');
                $table->timestamp('submitted_at')->nullable();
                $table->string('file_path')->nullable();
                $table->string('file_name')->nullable();
                $table->json('answers')->nullable();
                $table->decimal('score', 5, 2)->nullable();
                $table->timestamps();
                $table->index('student_id', 'assignment_attempt_student_lookup_index');
            });
        }

        $indexName = 'assignment_attempt_student_try_unique';
        $hasIndex = collect(Schema::getIndexes('assignment_attempts'))
            ->contains(fn (array $index) => $index['name'] === $indexName);

        if (!$hasIndex) {
            Schema::table('assignment_attempts', function (Blueprint $table) use ($indexName) {
                $table->unique(['assignment_id', 'student_id', 'attempt_number'], $indexName);
            });
        }

    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_attempts');
    }
};