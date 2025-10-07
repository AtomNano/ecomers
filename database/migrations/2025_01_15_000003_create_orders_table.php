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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_price', 15, 2);
            $table->string('status')->default('pending'); // pending, processing, completed, cancelled
            $table->text('shipping_address');
            $table->string('courier');
            $table->string('payment_method');
            $table->string('proof_of_payment')->nullable();
            $table->string('phone_number');
            $table->string('payment_status')->default('unpaid'); // unpaid, paid, failed, accepted, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};



