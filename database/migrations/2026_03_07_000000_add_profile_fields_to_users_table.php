<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('phone_country_code')->nullable()->after('phone');
            $table->string('address_street')->nullable()->after('receive_marketing');
            $table->string('address_city')->nullable()->after('address_street');
            $table->string('address_postal_code')->nullable()->after('address_city');
            $table->string('address_country')->nullable()->after('address_postal_code');
            $table->text('bio')->nullable()->after('address_country');
            $table->string('city')->nullable()->after('bio');
            $table->string('profession')->nullable()->after('city');
            $table->json('languages_spoken')->nullable()->after('profession');
            $table->json('interests')->nullable()->after('languages_spoken');
            $table->string('profile_photo_url')->nullable()->after('interests');
            $table->string('preferred_language')->default('fr')->after('profile_photo_url');
            $table->string('preferred_currency')->default('CAD')->after('preferred_language');
            $table->string('timezone')->default('America/Montreal')->after('preferred_currency');
            $table->json('notification_preferences')->nullable()->after('timezone');
            $table->boolean('phone_verified')->default(false)->after('notification_preferences');
            $table->boolean('identity_verified')->default(false)->after('phone_verified');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'phone_country_code',
                'address_street', 'address_city', 'address_postal_code', 'address_country',
                'bio', 'city', 'profession', 'languages_spoken', 'interests',
                'profile_photo_url', 'preferred_language', 'preferred_currency', 'timezone',
                'notification_preferences', 'phone_verified', 'identity_verified',
            ]);
        });
    }
};
