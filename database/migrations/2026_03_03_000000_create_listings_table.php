<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['draft', 'pending', 'active', 'rejected', 'archived'])->default('pending');

            // Property type
            $table->string('rental_frequency')->nullable(); // occasional, dedicated
            $table->string('space_type')->nullable();       // entire, private, shared

            // Location
            $table->string('full_address')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('mrc')->nullable();
            $table->string('county')->nullable();
            $table->string('province')->default('QC');
            $table->string('country')->default('CA');

            // Capacity
            $table->unsignedInteger('capacity')->default(1);
            $table->unsignedInteger('adults')->nullable();
            $table->unsignedInteger('bathrooms')->default(1);
            $table->json('bedrooms_data')->nullable();
            $table->json('open_areas_data')->nullable();

            // Features & Rules
            $table->json('amenities')->nullable();
            $table->json('expectations')->nullable();
            $table->json('permissions')->nullable();

            // Content
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->text('about_chalet')->nullable();
            $table->text('host_availability')->nullable();
            $table->text('neighborhood')->nullable();
            $table->text('transport')->nullable();
            $table->text('other_info')->nullable();

            // Reservation settings
            $table->string('reservation_mode')->default('request'); // request, instant
            $table->string('arrival_time')->nullable();
            $table->string('departure_time')->nullable();
            $table->unsignedInteger('min_age')->default(18);
            $table->string('min_stay')->nullable();
            $table->string('max_stay')->nullable();
            $table->json('arrival_days')->nullable();
            $table->json('departure_days')->nullable();

            // Pricing
            $table->string('currency')->default('CAD');
            $table->decimal('base_price', 10, 2)->nullable();
            $table->decimal('weekend_price', 10, 2)->nullable();
            $table->decimal('weekly_price', 10, 2)->nullable();
            $table->decimal('monthly_price', 10, 2)->nullable();
            $table->decimal('cleaning_fee', 10, 2)->nullable();
            $table->decimal('security_deposit', 10, 2)->nullable();
            $table->decimal('extra_guest_fee', 10, 2)->nullable();
            $table->decimal('pet_fee', 10, 2)->nullable();

            // Policy
            $table->string('cancellation_policy')->nullable();

            // Taxes (stored as JSON to preserve French month names)
            $table->json('tax_registration')->nullable();
            $table->boolean('taxes_included')->nullable();

            // Legal
            $table->boolean('accepted_local_laws')->default(false);

            // Guest arrival
            $table->string('wifi_speed')->nullable();
            $table->boolean('has_wifi')->nullable();
            $table->string('checkin_method')->nullable();
            $table->text('checkin_instructions')->nullable();

            // Contact
            $table->string('phone_number')->nullable();
            $table->string('country_code')->nullable();

            // Signature
            $table->string('signature_name')->nullable();
            $table->timestamp('signed_at')->nullable();

            // Host photo (path in storage)
            $table->string('host_photo_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
