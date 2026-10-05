<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('course_name')->nullable();
            $table->string('course_code')->nullable();
            $table->string('department')->nullable();
            $table->text('description')->nullable();
            $table->decimal('credit', 3, 1)->default(3.0);
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};