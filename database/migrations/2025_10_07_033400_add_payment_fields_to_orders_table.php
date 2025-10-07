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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->unique()->after('id');
            $table->string('customer_name')->after('user_id');
            $table->string('customer_email')->after('customer_name');
            $table->string('customer_phone')->after('customer_email');
            $table->text('shipping_address')->change();
            $table->string('shipping_province')->after('shipping_address');
            $table->string('shipping_city')->after('shipping_province');
            $table->string('shipping_district')->after('shipping_city');
            $table->string('shipping_postal_code')->nullable()->after('shipping_district');
            $table->string('shipping_method')->after('shipping_postal_code');
            $table->decimal('shipping_cost', 15, 2)->default(0)->after('shipping_method');
            $table->decimal('subtotal', 15, 2)->after('shipping_cost');
            $table->decimal('total', 15, 2)->after('subtotal');
            $table->string('status')->default('pending_payment')->change();
            $table->string('payment_proof')->nullable()->after('payment_method');
            $table->text('payment_notes')->nullable()->after('payment_proof');
            $table->text('notes')->nullable()->after('payment_notes');
            $table->string('tracking_number')->nullable()->after('notes');
            $table->dropColumn(['courier', 'proof_of_payment', 'phone_number', 'payment_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'order_number', 'customer_name', 'customer_email', 'customer_phone',
                'shipping_province', 'shipping_city', 'shipping_district', 'shipping_postal_code',
                'shipping_method', 'shipping_cost', 'subtotal', 'total',
                'payment_proof', 'payment_notes', 'notes', 'tracking_number'
            ]);
            $table->string('courier')->after('shipping_address');
            $table->string('proof_of_payment')->nullable()->after('payment_method');
            $table->string('phone_number')->after('proof_of_payment');
            $table->string('payment_status')->default('unpaid')->after('phone_number');
        });
    }
};