<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
            $table->foreignId('host_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('guest_id')->constrained('users')->onDelete('cascade');
            $table->boolean('host_archived')->default(false);
            $table->boolean('guest_archived')->default(false);
            $table->timestamps();

            $table->unique('reservation_id');
            $table->index('host_id');
            $table->index('guest_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
