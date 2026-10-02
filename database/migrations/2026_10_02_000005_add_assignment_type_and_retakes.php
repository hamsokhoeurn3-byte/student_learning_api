<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->string('assignment_type', 20)->default('file_upload')->after('ends_at');
            $table->boolean('allow_retakes')->default(false)->after('assignment_type');
            $table->unsignedSmallInteger('max_attempts')->default(1)->after('allow_retakes');
        });
    }

    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn(['assignment_type', 'allow_retakes', 'max_attempts']);
        });
    }
};