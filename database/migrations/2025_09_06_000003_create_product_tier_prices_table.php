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
        Schema::create('product_tier_prices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignUuid('customer_group_id')->nullable()->constrained('customer_groups')->onDelete('cascade');
            $table->integer('min_quantity');
            $table->decimal('price', 15, 2);
            $table->string('tier_name')->nullable(); // e.g., "Eceran", "Grosir", "Kartonan"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['product_id', 'customer_group_id', 'min_quantity'], 'unique_tier_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_tier_prices');
    }
};
