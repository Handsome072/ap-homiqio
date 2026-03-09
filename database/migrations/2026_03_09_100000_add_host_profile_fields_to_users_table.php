<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('bank_verified')->default(false)->after('identity_verified');
            $table->boolean('address_verified')->default(false)->after('bank_verified');
            $table->timestamp('verification_date')->nullable()->after('address_verified');
            $table->unsignedInteger('fraud_score')->default(5)->after('verification_date');
            $table->timestamp('last_login_at')->nullable()->after('fraud_score');
            $table->string('last_login_ip')->nullable()->after('last_login_at');
            $table->string('last_login_device')->nullable()->after('last_login_ip');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bank_verified', 'address_verified', 'verification_date',
                'fraud_score', 'last_login_at', 'last_login_ip', 'last_login_device',
            ]);
        });
    }
};
