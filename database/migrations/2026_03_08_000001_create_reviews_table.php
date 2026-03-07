<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('rating', 2, 1);
            $table->text('text')->nullable();
            $table->decimal('cleanliness_rating', 2, 1)->nullable();
            $table->decimal('accuracy_rating', 2, 1)->nullable();
            $table->decimal('checkin_rating', 2, 1)->nullable();
            $table->decimal('communication_rating', 2, 1)->nullable();
            $table->decimal('location_rating', 2, 1)->nullable();
            $table->decimal('value_rating', 2, 1)->nullable();
            $table->timestamps();

            $table->index(['listing_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
