<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Helpers\PricingHelper;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * ADD TO CART - SECURITY FIX #1
     * 
     * ❌ FATAL BUG SEBELUMNYA:
     * - Form menerima 'price_type' dari user input
     * - User bisa kirim quantity=1, price_type='dozen' → harga murah
     * - Toko rugi besar-besaran
     * 
     * ✅ SOLUSI:
     * - Hapus 'price_type' dari validasi
     * - JANGAN terima input user untuk menentukan harga
     * - Harga dihitung otomatis oleh sistem (PricingHelper)
     * - Berdasarkan TOTAL quantity di keranjang
     */
    public function add(Request $request, Product $product)
    {
        // 1. Validasi HANYA quantity
        // product sudah dari route binding, tidak perlu validate product_id
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        $userId = auth()->id();
        $productId = $product->id;
        $qtyToAdd = $validated['quantity'];
        
        // 2. Cek apakah produk SUDAH ada di keranjang
        // ❌ JANGAN check price_type! Itu celah keamanan.
        $cartItem = Cart::where('user_id', $userId)
                       ->where('product_id', $productId)
                       ->first();
        
        if ($cartItem) {
            // 3. GABUNGKAN quantity
            // Smart pricing akan otomatis triggered saat checkout
            $cartItem->increment('quantity', $qtyToAdd);
        } else {
            // 4. Buat item baru
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $qtyToAdd,
                // price_type TIDAK disimpan di cart
                // Akan dikalkulasi realtime saat display/checkout
            ]);
        }
        
        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    /**
     * VIEW CART - SMART PRICING CALCULATION
     * 
     * ✅ REALTIME PRICING:
     * - Total harga dihitung saat view, tidak pernah disimpan di DB
     * - Menggunakan PricingHelper yang sudah robust
     * - Jika user update quantity, harga tier otomatis berubah
     */
    public function index()
    {
        // Eager load product untuk efisiensi
        $cartItems = auth()->user()->carts()->with('product')->get();
        
        // Kalkulasi harga REALTIME untuk setiap item
        $subtotal = 0;
        
        foreach ($cartItems as $item) {
            // Panggil PricingHelper yang sudah terbukti aman
            $priceInfo = PricingHelper::calculateItemPrice($item->product, $item->quantity);
            
            // Inject data harga ke object untuk dipakai di View
            $item->price_calculated = $priceInfo['effective_price'];     // Harga per unit setelah tier
            $item->total_price = $priceInfo['total_price'];             // Total untuk qty ini
            $item->active_tier = $priceInfo['price_type'];              // Tier mana (unit/bulk/dozen)
            
            $subtotal += $item->total_price;
        }
        
        return view('customer.cart', compact('cartItems', 'subtotal'));
    }

    /**
     * UPDATE CART QUANTITY
     * 
     * ✅ LOGIC FIX #2:
     * - Jangan ada "mulai dari 0"
     * - Jika quantity=0, delete instead of update
     * - Quantity yang diminta harus valid
     */
    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        
        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);
        
        // Update quantity
        $cart->update(['quantity' => $request->quantity]);
        
        // Proses pricing akan otomatis di index() saat redirect
        return back()->with('success', 'Keranjang diupdate');
    }

    /**
     * REMOVE ITEM FROM CART
     */
    public function remove($id)
    {
        Cart::where('user_id', auth()->id())
            ->findOrFail($id)
            ->delete();
        
        return back()->with('success', 'Item dihapus dari keranjang');
    }

    /**
     * CLEAR ALL CART ITEMS
     */
    public function clear()
    {
        auth()->user()->carts()->delete();
        return back()->with('success', 'Keranjang dikosongkan');
    }
}

