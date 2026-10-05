<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (! Schema::hasColumn('courses', 'day_of_week')) {
                $table->string('day_of_week')->nullable()->after('semester');
            }
            if (! Schema::hasColumn('courses', 'start_time')) {
                $table->time('start_time')->nullable()->after('day_of_week');
            }
            if (! Schema::hasColumn('courses', 'end_time')) {
                $table->time('end_time')->nullable()->after('start_time');
            }
            if (! Schema::hasColumn('courses', 'room')) {
                $table->string('room')->nullable()->after('end_time');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['day_of_week', 'start_time', 'end_time', 'room']);
        });
    }
};
