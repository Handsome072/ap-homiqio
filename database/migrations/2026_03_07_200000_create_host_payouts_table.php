<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('host_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reservation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->decimal('gross_amount', 10, 2);
            $table->decimal('commission_rate', 5, 2)->default(15.00);
            $table->decimal('commission_amount', 10, 2);
            $table->decimal('cleaning_fee', 10, 2)->default(0);
            $table->decimal('taxes', 10, 2)->default(0);
            $table->decimal('net_amount', 10, 2);
            $table->string('currency', 3)->default('CAD');
            $table->enum('status', ['pending', 'scheduled', 'paid', 'failed'])->default('pending');
            $table->date('scheduled_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->string('reference')->nullable();
            $table->timestamps();

            $table->index(['host_id', 'status']);
            $table->index(['host_id', 'paid_date']);
            $table->index('scheduled_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('host_payouts');
    }
};
