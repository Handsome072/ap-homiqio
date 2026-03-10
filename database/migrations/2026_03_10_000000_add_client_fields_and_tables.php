<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add client-specific fields to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('client_status')->default('ACTIF')->after('host_status');
            $table->boolean('is_suspect')->default(false)->after('client_status');
            $table->integer('login_count')->default(0)->after('last_login_device');
            $table->integer('failed_logins')->default(0)->after('login_count');
        });

        // Guest reviews: hosts reviewing guests after a stay
        Schema::create('guest_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('guest_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reservation_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('listing_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('rating', 2, 1);
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        // Client reports / signalements
        Schema::create('client_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->string('reason');
            $table->text('description')->nullable();
            $table->string('status')->default('OUVERT');
            $table->timestamps();
        });

        // Activity logs for user actions
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('action');
            $table->string('detail')->nullable();
            $table->string('ip')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('client_reports');
        Schema::dropIfExists('guest_reviews');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['client_status', 'is_suspect', 'login_count', 'failed_logins']);
        });
    }
};
