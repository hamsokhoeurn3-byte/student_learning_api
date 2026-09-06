<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('teacher_id')
                ->unique();

            $table->string('first_name');

            $table->string('last_name');

            $table->date('date_of_birth')
                ->nullable();

            $table->enum('gender', [
                'Male',
                'Female',
            ])->nullable();

            $table->string('phone')
                ->nullable();

            $table->string('department')
                ->nullable();

            $table->string('position')
                ->nullable();

            $table->string('specialization')
                ->nullable();

            $table->string('status')
                ->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};