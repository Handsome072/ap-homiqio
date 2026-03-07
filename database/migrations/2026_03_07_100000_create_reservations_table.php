<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('listing_id')->constrained('listings')->onDelete('cascade');
            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedSmallInteger('guests_count')->default(1);
            $table->enum('status', ['pending', 'confirmed', 'active', 'completed', 'cancelled'])->default('pending');
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('currency', 3)->default('EUR');
            $table->text('guest_message')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();

            $table->index(['guest_id', 'status']);
            $table->index(['listing_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
