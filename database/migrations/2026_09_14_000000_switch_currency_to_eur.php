<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Switch the platform currency from CAD to EUR.
     * Only the currency code changes: amounts are kept as-is (no exchange-rate conversion).
     */
    public function up(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->string('currency')->default('EUR')->change();
        });

        Schema::table('host_payouts', function (Blueprint $table) {
            $table->string('currency', 3)->default('EUR')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('preferred_currency')->default('EUR')->change();
        });

        DB::table('listings')->where('currency', '!=', 'EUR')->update(['currency' => 'EUR']);
        DB::table('reservations')->where('currency', '!=', 'EUR')->update(['currency' => 'EUR']);
        DB::table('host_payouts')->where('currency', '!=', 'EUR')->update(['currency' => 'EUR']);
        DB::table('users')->where('preferred_currency', 'CAD')->update(['preferred_currency' => 'EUR']);
    }

    /**
     * Revert the column defaults. Row values are not restored to their previous currencies.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->string('currency')->default('CAD')->change();
        });

        Schema::table('host_payouts', function (Blueprint $table) {
            $table->string('currency', 3)->default('CAD')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('preferred_currency')->default('CAD')->change();
        });
    }
};
