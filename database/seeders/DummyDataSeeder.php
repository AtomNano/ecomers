<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Pastikan ada Produk Dulu
        $products = Product::all();
        if($products->isEmpty()) {
            $this->command->info('⚠️  Tidak ada produk! Jalankan ProductSeeder dulu.');
            return;
        }

        // 2. Buat 10 Customer Palsu
        $this->command->info('📝 Creating Customers...');
        $customers = User::factory()->count(10)->create(['role' => 'customer']);

        // 3. Buat Transaksi Historis (Agar Grafik Bagus)
        $this->command->info('💰 Generating Transaction History...');
        
        for ($i = 0; $i < 50; $i++) {
            $customer = $customers->random();
            
            // Random tanggal tahun ini
            $date = Carbon::createFromDate(date('Y'), rand(1, 12), rand(1, 28));
            
            // Create Order
            $order = Order::create([
                'user_id' => $customer->id,
                'invoice_number' => 'INV/' . $date->format('Y/m') . '/' . rand(1000, 9999),
                'total_amount' => 0, // Nanti dihitung ulang
                'status' => 'completed', // Langsung selesai biar masuk laporan
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone ?? '0812-3456-7890',
                'customer_address' => $customer->address ?? 'Jl. Demo No.123, Jakarta',
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            // Add Items (1-5 produk per order)
            $subtotal = 0;
            $itemsCount = rand(1, 5);
            
            for ($j = 0; $j < $itemsCount; $j++) {
                $product = $products->random();
                $qty = rand(1, 20);
                
                // FIXED: Ambil box count dari produk, jangan hardcode 12!
                $boxLimit = $product->box_item_count ?? 12;
                
                // Hitung harga berdasarkan quantity tier yang benar
                $price = $product->price_unit;
                if ($qty >= $boxLimit) {
                    // Jika beli >= 1 dus, pakai harga dus dibagi isi
                    $price = round($product->price_dozen / $boxLimit, 0);
                } elseif ($qty >= 4) {
                    $price = $product->price_bulk_4;
                }
                
                $lineTotal = $price * $qty;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'subtotal' => $lineTotal,
                    'created_at' => $date,
                ]);

                $subtotal += $lineTotal;
            }

            // Update Total Order
            $order->update(['total_amount' => $subtotal]);

            // Create Payment Record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'transfer',
                'status' => 'verified',
                'amount' => $subtotal,
                'created_at' => $date,
            ]);
        }

        $this->command->info('✅ Dummy Data Berhasil! Grafik Owner sekarang berwarna-warni.');
    }
}
