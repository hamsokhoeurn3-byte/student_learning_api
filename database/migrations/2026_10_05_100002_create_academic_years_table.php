<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();

            // e.g. "2025-2026"
            $table->string('name', 20)->unique();
            $table->date('start_date');
            $table->date('end_date');

            // active | inactive | completed (only one "active" normally; enforced by the service layer)
            $table->string('status', 20)->default('inactive');

            $table->timestamps();

            $table->index('status');
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_years');
    }
};
