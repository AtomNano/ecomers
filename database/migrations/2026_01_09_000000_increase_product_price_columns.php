<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Increase precision to 15 digits total, 2 decimal places (up to 9,999,999,999,999.99)
            $table->decimal('price_unit', 15, 2)->change();
            $table->decimal('price_bulk_4', 15, 2)->nullable()->change();
            $table->decimal('price_dozen', 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert to original size (12, 2)
            $table->decimal('price_unit', 12, 2)->change();
            $table->decimal('price_bulk_4', 12, 2)->nullable()->change();
            $table->decimal('price_dozen', 12, 2)->nullable()->change();
        });
    }
};
