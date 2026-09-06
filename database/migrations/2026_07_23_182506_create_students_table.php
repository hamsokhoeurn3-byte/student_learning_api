<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('student_id')
                ->unique();

            $table->string('first_name');

            $table->string('last_name');

            $table->date('date_of_birth');

            $table->enum('gender', [
                'Male',
                'Female',
            ]);

            $table->string('nationality')
                ->default('Cambodian');

            $table->string('phone')
                ->nullable();

            $table->text('address')
                ->nullable();

            $table->string('department')
                ->nullable();

            $table->string('major')
                ->nullable();

            $table->string('academic_year')
                ->nullable();

            $table->string('year_level')
                ->nullable();

            $table->string('semester')
                ->nullable();

            $table->string('advisor')
                ->nullable();

            $table->date('enrollment_date')
                ->nullable();

            $table->enum('status', [
                'enrolled',
                'graduated',
                'suspended',
                'inactive',
            ])->default('enrolled');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};