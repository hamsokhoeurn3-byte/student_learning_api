<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table creation for `classes` is consolidated into canonical migration
     * 2026_10_05_100005_create_classes_table.php which supports both course scheduling
     * and SLAS department/academic structure.
     */
    public function up(): void
    {
        if (! Schema::hasTable('classes')) {
            Schema::create('classes', function (Blueprint $table) {
                $table->id();

                $table->foreignId('course_id')
                    ->nullable()
                    ->constrained('courses')
                    ->nullOnDelete();

                $table->foreignId('teacher_id')
                    ->nullable()
                    ->constrained('teachers')
                    ->nullOnDelete();

                $table->string('name', 100);
                $table->string('code', 40)->unique();

                $table->string('day_of_week', 20)->nullable();
                $table->time('start_time')->nullable();
                $table->time('end_time')->nullable();
                $table->string('room', 100)->nullable();

                $table->string('status', 20)->default('active');

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
