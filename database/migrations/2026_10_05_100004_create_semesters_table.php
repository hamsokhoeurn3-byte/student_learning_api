<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();

            // Semester history must survive: deleting an academic year is blocked while it has semesters.
            $table->foreignId('academic_year_id')
                ->constrained('academic_years')
                ->restrictOnDelete();

            $table->string('name', 50);
            $table->unsignedTinyInteger('semester_number');
            $table->date('start_date');
            $table->date('end_date');

            // upcoming | active | completed
            $table->string('status', 20)->default('upcoming');

            $table->timestamps();

            $table->unique(['academic_year_id', 'semester_number'], 'semesters_year_number_unique');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
