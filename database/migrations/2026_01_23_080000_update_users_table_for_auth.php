<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the old name column and add separate first/last name
            $table->dropColumn('name');
            
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->date('birth_date')->nullable()->after('password');
            $table->boolean('receive_marketing')->default(false)->after('birth_date');
            $table->string('email_verification_token')->nullable()->after('email_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'birth_date', 'receive_marketing', 'email_verification_token']);
            $table->string('name')->after('id');
        });
    }
};

