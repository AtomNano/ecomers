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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->decimal('price_unit', 12, 2)->comment('Harga per satuan (1 pcs)');
            $table->decimal('price_bulk_4', 12, 2)->nullable()->comment('Harga untuk pembelian > 4 pcs');
            $table->decimal('price_dozen', 12, 2)->nullable()->comment('Harga per lusin/dus');
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
