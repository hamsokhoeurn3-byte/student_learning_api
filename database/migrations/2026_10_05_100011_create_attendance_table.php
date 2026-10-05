<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('attendance')) {
            Schema::create('attendance', function (Blueprint $table) {
                $table->id();

                $table->foreignId('course_id')->constrained('courses')->restrictOnDelete();
                $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
                $table->foreignId('semester_id')->nullable()->constrained('semesters')->nullOnDelete();
                $table->foreignId('student_id')->nullable()->constrained('students')->nullOnDelete();
                $table->foreignId('marked_by')->nullable()->constrained('users')->nullOnDelete();

                $table->date('attendance_date');
                $table->time('start_time')->nullable();
                $table->time('end_time')->nullable();
                $table->string('topic', 255)->nullable();

                // scheduled | completed | cancelled
                $table->string('status', 20)->default('scheduled');

                $table->text('notes')->nullable();

                $table->timestamps();

                $table->index('attendance_date');
            });
        } else {
            Schema::table('attendance', function (Blueprint $table) {
                if (! Schema::hasColumn('attendance', 'student_id')) {
                    $table->foreignId('student_id')->nullable()->constrained('students')->nullOnDelete();
                }
                if (! Schema::hasColumn('attendance', 'marked_by')) {
                    $table->foreignId('marked_by')->nullable()->constrained('users')->nullOnDelete();
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
