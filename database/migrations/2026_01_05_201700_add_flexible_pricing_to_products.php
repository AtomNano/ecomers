<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menambahkan field untuk sistem harga grosir yang fleksibel:
     * - bulk_min_qty: Minimum quantity untuk mendapat harga grosir (tidak lagi fixed 4+)
     * - box_item_count: Jumlah item dalam 1 dus/box (sudah ada via migration lain, dipastikan ada)
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Minimum quantity untuk mendapat harga grosir (default 4 untuk backward compatibility)
            if (!Schema::hasColumn('products', 'bulk_min_qty')) {
                $table->integer('bulk_min_qty')->default(4)->after('price_bulk_4')
                    ->comment('Minimum qty untuk harga grosir');
            }
            
            // Pastikan box_item_count ada
            if (!Schema::hasColumn('products', 'box_item_count')) {
                $table->integer('box_item_count')->default(12)->after('price_dozen')
                    ->comment('Jumlah item per dus/box');
            }
            
            // Rename price_bulk_4 to price_bulk untuk kejelasan (optional, keep both for compatibility)
            // Tidak rename untuk menjaga backward compatibility
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'bulk_min_qty')) {
                $table->dropColumn('bulk_min_qty');
            }
        });
    }
};
