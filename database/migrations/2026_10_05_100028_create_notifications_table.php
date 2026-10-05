<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Application notifications for the Android client (own schema; NOT Laravel's
        // built-in database notification channel table).
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('title', 200);
            $table->text('message');

            // assignment | quiz | exam | attendance | prediction | risk | recommendation | system
            $table->string('type', 30)->default('system');

            // Lightweight polymorphic pointer so the app can deep-link, e.g. ("assignment", 12).
            $table->string('reference_type', 50)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();

            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'is_read'], 'notifications_user_read_index');
            $table->index(['user_id', 'created_at'], 'notifications_user_created_index');
            $table->index(['reference_type', 'reference_id'], 'notifications_reference_index');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
