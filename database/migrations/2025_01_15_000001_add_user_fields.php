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
            $table->text('address')->nullable()->after('password');
            $table->string('phone_number')->nullable()->after('address');
            $table->string('province')->nullable()->after('phone_number');
            $table->string('city')->nullable()->after('province');
            $table->string('district')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'phone_number', 'province', 'city', 'district']);
        });
    }
};



