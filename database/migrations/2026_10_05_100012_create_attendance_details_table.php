<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('attendance_id')->constrained('attendance')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            // present | absent | late | excused
            $table->string('status', 20)->default('present');

            $table->string('remarks', 255)->nullable();

            $table->timestamps();

            $table->unique(['attendance_id', 'student_id'], 'attendance_details_attendance_student_unique');
            $table->index(['student_id', 'status'], 'attendance_details_student_status_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_details');
    }
};
