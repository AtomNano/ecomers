<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Helpers\PricingHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\StoreSetting;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = auth()->user()->carts()->with('product')->get();
        
        if ($carts->isEmpty()) {
            return redirect()->route('customer.products.index')
                            ->with('error', 'Keranjang kosong');
        }
        
        // Calculate total dengan pricing engine
        $cartItems = [];
        $subtotal = 0;
        
        foreach ($carts as $cart) {
            $priceInfo = PricingHelper::calculateItemPrice($cart->product, $cart->quantity);
            $cart->priceInfo = $priceInfo;
            $subtotal += $priceInfo['total_price'];
            $cartItems[] = $cart;
        }
        
        $user = auth()->user();
        $storeSetting = StoreSetting::first();
        
        return view('customer.checkout', compact('cartItems', 'subtotal', 'user', 'storeSetting'));
    }

    /**
     * Store order dengan transaction untuk data integrity
     * 
     * Step 1: Calculate prices menggunakan pricing engine
     * Step 2: Create Order (head)
     * Step 3: Create OrderItems dengan price snapshot
     * Step 4: Deduct stock (WAJIB dari tabel products)
     * Step 5: Create Payment
     * Step 6: Clear cart
     * 
     * Jika ada error di step mana pun, DB::rollBack otomatis batal semua
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_method' => 'required|in:gosend,pickup,custom',
            'payment_method' => 'required|in:transfer,qris',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
        ]);
        
        $carts = auth()->user()->carts()->with('product')->get();
        
        if ($carts->isEmpty()) {
            return redirect()->route('customer.products.index')
                            ->with('error', 'Keranjang kosong');
        }
        
        // Hitung shipping cost
        $shippingCost = $this->calculateShippingCost($validated['shipping_method']);
        
        // ===== DATABASE TRANSACTION =====
        // Semua operasi dibawah ini adalah "all or nothing"
        // Jika error di step 3, step 1-2 akan di-rollback otomatis
        $order = DB::transaction(function () use ($carts, $validated, $shippingCost) {
            
            // STEP 1: Calculate subtotal dengan pricing engine
            $subtotal = 0;
            $cartData = []; // Simpan untuk Step 3
            
            foreach ($carts as $cart) {
                $product = $cart->product;
                
                // Use PricingHelper untuk hitung effective price
                $priceInfo = PricingHelper::calculateItemPrice($product, $cart->quantity);
                
                $cartData[] = [
                    'product' => $product,
                    'quantity' => $cart->quantity,
                    'priceInfo' => $priceInfo,
                ];
                
                $subtotal += $priceInfo['total_price'];
            }
            
            $totalAmount = $subtotal + $shippingCost;
            
            // STEP 2: Create Order (head) dengan invoice number
            $order = Order::create([
                'user_id' => auth()->id(),
                'invoice_number' => $this->generateInvoiceNumber(), // INV/2025/12/0001
                'total_amount' => $totalAmount,
                'shipping_cost' => $shippingCost,
                'shipping_method' => $validated['shipping_method'],
                'status' => 'pending',
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
            ]);
            
            // STEP 3: Create OrderItems dengan price snapshot
            foreach ($cartData as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price_type' => $item['priceInfo']['price_type'],
                    'unit_price' => $item['priceInfo']['effective_price'], // Snapshot harga
                    'subtotal' => $item['priceInfo']['total_price'],
                ]);
                
                // STEP 4: RACE CONDITION FIX - Lock product row saat checkout
                // 
                // MASALAH LAMA:
                // User A & B checkout Indomie sisa 10 unit secara bersamaan
                // Keduanya baca stok = 10
                // Keduanya berhasil checkout
                // Stok jadi -10 (phantom inventory)
                // 
                // SOLUSI:
                // Gunakan lockForUpdate() untuk kunci row selama transaction
                // Jika User B checkout sambil User A sedang proses,
                // User B akan tunggu sampai User A selesai
                // Jadi yang terjadi: User A checkout OK, User B dapat error "stok tidak cukup"
                
                $product = Product::lockForUpdate()->findOrFail($item['product']->id);
                
                // Cek ulang stok di dalam transaction (double-check)
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak cukup! Sisa: {$product->stock} pcs, Diminta: {$item['quantity']} pcs");
                }
                
                // Kurangi stok
                $product->decrement('stock', $item['quantity']);
            }
            
            // STEP 5: Create Payment record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
                'amount' => $totalAmount,
            ]);
            
            // STEP 6: Clear cart
            auth()->user()->carts()->delete();
            
            return $order;
            
        }, 3); // 3 retries untuk transaction
        
        // Send Notification to Admin & Owner
        try {
            $recipients = \App\Models\User::whereIn('role', ['admin', 'owner'])->get();
            \Illuminate\Support\Facades\Notification::send($recipients, new \App\Notifications\NewOrderNotification($order));
        } catch (\Exception $e) {
            // Ignore notification error to not block checkout
            \Illuminate\Support\Facades\Log::error('Notification Error: ' . $e->getMessage());
        }

        // Redirect ke payment upload page
        return redirect()->route('customer.payment.show', $order)
                       ->with('success', 'Pesanan berhasil dibuat. Silakan upload bukti pembayaran.');
    }
    
    /**
     * Generate unique invoice number
     * Format: INV/2025/12/0001
     */
    private function generateInvoiceNumber(): string
    {
        $now = now();
        $year = $now->year;
        $month = $now->month;
        
        // Get last invoice number dari bulan ini
        $lastOrder = Order::whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->latest('id')
                        ->first();
        
        $nextNumber = 1;
        if ($lastOrder && $lastOrder->invoice_number) {
            $parts = explode('/', $lastOrder->invoice_number);
            $nextNumber = (int) end($parts) + 1;
        }
        
        return sprintf('INV/%d/%02d/%04d', $year, $month, $nextNumber);
    }
    
    /**
     * Calculate shipping cost berdasarkan method
     * 
     * ✅ BEST PRACTICE FIX #4: 
     * Daripada hardcode 15000 di sini, ambil dari config/shipping.php
     * 
     * Kenapa penting?
     * - Jika harga BBM naik, admin bisa update tanpa edit controller
     * - Jika toko pindah lokasi, config bisa disesuaikan dengan mudah
     * - Tidak perlu redeploy code, cukup update config file
     */
    private function calculateShippingCost(string $method): int
    {
        $shippingConfig = config('shipping.methods');
        
        if (!isset($shippingConfig[$method])) {
            return 0;
        }
        
        return (int) $shippingConfig[$method]['cost'];
    }
}
