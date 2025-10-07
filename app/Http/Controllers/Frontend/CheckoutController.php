<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price_per_piece;
        });

        return view('frontend.checkout.index', compact('cartItems', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'courier' => 'required|string',
            'payment_method' => 'required|string|in:transfer,qris',
        ]);

        $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();
        
        try {
            $total = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price_per_piece;
            });

            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $total,
                'status' => 'pending',
                'shipping_address' => auth()->user()->address,
                'courier' => $request->courier,
                'payment_method' => $request->payment_method,
                'phone_number' => auth()->user()->phone_number,
                'payment_status' => 'unpaid',
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price_per_piece,
                ]);
            }

            // Clear cart
            CartItem::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order)->with('success', 'Pesanan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan');
        }
    }

    public function success(Order $order)
    {
        return view('frontend.checkout.success', compact('order'));
    }

    public function uploadProof(Request $request, Order $order)
    {
        $request->validate([
            'proof_of_payment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($request->hasFile('proof_of_payment')) {
            $file = $request->file('proof_of_payment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('proofs', $filename, 'public');
            
            $order->update([
                'proof_of_payment' => $filename,
                'payment_status' => 'paid',
            ]);

            return redirect()->route('home')->with('success', 'Bukti pembayaran berhasil diupload');
        }

        return redirect()->back()->with('error', 'Gagal mengupload bukti pembayaran');
    }
}

