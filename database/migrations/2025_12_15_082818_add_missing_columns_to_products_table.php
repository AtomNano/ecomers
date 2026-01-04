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
        Schema::table('products', function (Blueprint $table) {
            // Add unit (Pcs, Botol, Bungkus, etc) - only if not exists
            if (!Schema::hasColumn('products', 'unit')) {
                $table->string('unit')->default('Pcs')->after('stock');
            }
            
            // CRITICAL: Jumlah item dalam 1 box/dus
            if (!Schema::hasColumn('products', 'box_item_count')) {
                $table->integer('box_item_count')->default(12)->comment('Jumlah pcs dalam 1 box/dus');
            }
            
            // Featured untuk dashboard highlight
            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'unit')) {
                $table->dropColumn('unit');
            }
            if (Schema::hasColumn('products', 'box_item_count')) {
                $table->dropColumn('box_item_count');
            }
            if (Schema::hasColumn('products', 'is_featured')) {
                $table->dropColumn('is_featured');
            }
        });
    }
};
