<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Schema;

class FakeOrderSeeder extends Seeder
{
    public function run()
    {
        // Clean up previous fake orders
        Schema::disableForeignKeyConstraints();
        DB::table('order_items')->truncate();
        DB::table('payments')->truncate();
        DB::table('orders')->truncate();
        Schema::enableForeignKeyConstraints();
        
        // Get Customers
        $customers = User::where('role', 'customer')->get();
        if($customers->isEmpty()) {
            // Create dummy customers if none
             User::factory()->count(10)->create(['role' => 'customer']);
             $customers = User::where('role', 'customer')->get();
        }

        $products = Product::all();
        if($products->isEmpty()) return;

        // Create 50 Fake Orders
        for ($i = 0; $i < 50; $i++) {
            try {
                $customer = $customers->random();
                $date = Carbon::now()->subDays(rand(0, 60)); // Last 2 months
                
                // Random Status (Valid Enum: pending, payment_verified, shipped, completed, cancelled)
                $rand = rand(1, 100);
                if ($rand <= 50) $status = 'completed';
                elseif ($rand <= 65) $status = 'shipped';
                elseif ($rand <= 75) $status = 'payment_verified'; // processing/verified
                elseif ($rand <= 85) $status = 'payment_verified';
                elseif ($rand <= 95) $status = 'pending'; // waiting verification
                else $status = 'cancelled';

                // Override status logic for Payments
                $paymentStatus = 'pending';
                if (in_array($status, ['shipped', 'completed', 'payment_verified'])) {
                    $paymentStatus = 'verified';
                } elseif ($status == 'cancelled') {
                    $paymentStatus = 'rejected';
                }

                // Create Order
                $order = Order::create([
                    'user_id' => $customer->id,
                    'invoice_number' => 'INV/' . $date->format('Y/m/') . strtoupper(Str::random(6)),
                    'total_amount' => 0, // Calculate later
                    'status' => $status,
                    'customer_name' => $customer->name,
                    'customer_phone' => $customer->phone ?? '08123456789',
                    'customer_address' => $customer->address ?? 'Jl. Contoh No. ' . rand(1, 100) . ', Jakarta',
                    'shipping_cost' => rand(10000, 50000),
                    'shipping_method' => 'gosend',
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);

                // Create Order Items (1-5 items)
                $total = 0;
                $itemCount = rand(1, 5);
                
                for ($j = 0; $j < $itemCount; $j++) {
                    $product = $products->random();
                    $qty = rand(1, 5);
                    $price = $product->price_unit;
                    
                    // Bulk logic roughly
                    if ($qty >= 4 && $product->price_bulk_4) $price = $product->price_bulk_4;
                    if ($qty >= 12 && $product->price_dozen) $price = $product->price_dozen / 12; // Approx

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'unit_price' => $price,
                        'subtotal' => $price * $qty,
                    ]);
                    $total += ($price * $qty);
                }

                // Update Total
                $order->update(['total_amount' => $total + $order->shipping_cost]);

                // Create Payment
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => 'transfer',
                    'amount' => $order->total_amount,
                    'status' => $paymentStatus,
                    'proof_image' => 'payment_proofs/dummy.jpg', // Dummy path
                    'paid_at' => $date,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("ERROR seeding order $i: " . $e->getMessage());
                echo "ERROR logged for order $i\n";
            }
        }
    }
}
