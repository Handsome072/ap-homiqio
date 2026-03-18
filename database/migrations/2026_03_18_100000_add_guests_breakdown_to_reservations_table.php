<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->unsignedSmallInteger('adults')->default(1)->after('guests_count');
            $table->unsignedSmallInteger('children')->default(0)->after('adults');
            $table->unsignedSmallInteger('infants')->default(0)->after('children');
            $table->unsignedSmallInteger('pets')->default(0)->after('infants');
            $table->decimal('service_fee', 10, 2)->nullable()->after('total_price');
            $table->decimal('cleaning_fee', 10, 2)->nullable()->after('service_fee');
            $table->unsignedSmallInteger('nights_count')->default(1)->after('cleaning_fee');
            $table->decimal('price_per_night', 10, 2)->nullable()->after('nights_count');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn([
                'adults',
                'children',
                'infants',
                'pets',
                'service_fee',
                'cleaning_fee',
                'nights_count',
                'price_per_night',
            ]);
        });
    }
};
