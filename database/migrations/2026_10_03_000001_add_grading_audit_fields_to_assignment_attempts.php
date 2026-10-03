<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assignment_attempts', function (Blueprint $table) {
            $table->foreignId('graded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('graded_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('assignment_attempts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('graded_by');
            $table->dropColumn('graded_at');
        });
    }
};