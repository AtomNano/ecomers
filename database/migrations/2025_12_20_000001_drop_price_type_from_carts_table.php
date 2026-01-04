<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * SECURITY FIX: Remove 'price_type' column from carts table.
     * 
     * Reason: price_type should NEVER be accepted from user input or stored in DB.
     * It is a CALCULATED property based on quantity, determined by PricingHelper.
     * 
     * Previous vulnerability: User could send 'price_type'='dozen' with quantity=1
     * to exploit pricing (paying Rp 3.000 instead of Rp 5.000).
     * 
     * New approach: price_type is calculated realtime in CartController::index()
     * using PricingHelper::calculateItemPrice() based on actual quantity.
     */
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('price_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->enum('price_type', ['unit', 'bulk_4', 'dozen'])->default('unit');
        });
    }
};
