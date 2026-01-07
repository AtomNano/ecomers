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
        // Change enum to string to allow 'midtrans' and flexible future methods
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_method')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to enum if necessary (optional, or just leave as string)
        Schema::table('payments', function (Blueprint $table) {
             // Creating enum again might be complex with data, leaving as string is safer
             // but strictly:
             // $table->enum('payment_method', ['transfer', 'qris', 'cod'])->change();
        });
    }
};
