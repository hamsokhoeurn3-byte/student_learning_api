<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $indexName = 'assignment_attempt_student_lookup_index';
        $hasIndex = collect(Schema::getIndexes('assignment_attempts'))
            ->contains(fn (array $index) => $index['name'] === $indexName);

        if (!$hasIndex) {
            Schema::table('assignment_attempts', function (Blueprint $table) use ($indexName) {
                $table->index('student_id', $indexName);
            });
        }
    }

    public function down(): void
    {
        $indexName = 'assignment_attempt_student_lookup_index';
        $hasIndex = collect(Schema::getIndexes('assignment_attempts'))
            ->contains(fn (array $index) => $index['name'] === $indexName);

        if ($hasIndex) {
            Schema::table('assignment_attempts', function (Blueprint $table) use ($indexName) {
                $table->dropIndex($indexName);
            });
        }
    }
};