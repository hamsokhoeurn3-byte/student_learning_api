<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('department_id')
                ->constrained('departments')
                ->restrictOnDelete();

            $table->foreignId('academic_year_id')
                ->constrained('academic_years')
                ->restrictOnDelete();

            $table->string('name', 100);
            $table->string('code', 40)->unique();

            // 1..4 (Year 1 .. Year 4)
            $table->unsignedTinyInteger('year_level');

            // active | inactive
            $table->string('status', 20)->default('active');

            $table->timestamps();

            $table->index(['department_id', 'academic_year_id'], 'classes_department_year_index');
            $table->index('year_level');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
