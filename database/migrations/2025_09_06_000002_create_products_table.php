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
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            
            // Tiered Pricing
            $table->decimal('price_per_piece', 15, 2)->comment('Harga satuan per pcs');
            $table->decimal('price_per_four', 15, 2)->nullable()->comment('Harga untuk pembelian lebih dari 4');
            $table->decimal('price_per_dozen', 15, 2)->nullable()->comment('Harga per lusin/dus');

            $table->integer('stock')->default(0);
            $table->boolean('is_featured')->default(false)->comment('Untuk Barang Terbaru');
            $table->unsignedBigInteger('sales_count')->default(0)->comment('Untuk Barang Terlaris');

            $table->foreignUuid('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
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