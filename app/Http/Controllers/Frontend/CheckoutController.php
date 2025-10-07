<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $cartItems = CartItem::with('product.category')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        return view('frontend.checkout.index', compact('cartItems'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:15',
            'shipping_address' => 'required|string',
            'shipping_province' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_district' => 'required|string|max:255',
            'shipping_postal_code' => 'nullable|string|max:10',
            'shipping_method' => 'required|in:gosend,pickup,courier',
            'payment_method' => 'required|in:virtual_account,qris,bank_transfer',
            'order_notes' => 'nullable|string|max:1000',
            'terms_accepted' => 'required|accepted',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        // Calculate shipping cost
        $shippingCosts = [
            'gosend' => 15000,
            'pickup' => 0,
            'courier' => 20000,
        ];

        $shippingCost = $shippingCosts[$request->shipping_method] ?? 0;

        // Calculate subtotal
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->getPriceForQuantity($item->quantity) * $item->quantity;
        });

        $total = $subtotal + $shippingCost;

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . date('Y') . '-' . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_province' => $request->shipping_province,
                'shipping_city' => $request->shipping_city,
                'shipping_district' => $request->shipping_district,
                'shipping_postal_code' => $request->shipping_postal_code,
                'shipping_method' => $request->shipping_method,
                'shipping_cost' => $shippingCost,
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'total' => $total,
                'status' => 'pending_payment',
                'notes' => $request->order_notes,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->getPriceForQuantity($cartItem->quantity),
                ]);
            }

            // Clear cart
            CartItem::where('user_id', Auth::id())->delete();

            DB::commit();

            // Redirect based on payment method
            if (in_array($request->payment_method, ['virtual_account', 'qris'])) {
                // Redirect to payment gateway
                return redirect()->route('checkout.payment', $order->id);
            } else {
                // Redirect to manual payment instructions
                return redirect()->route('checkout.manual-payment', $order->id);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    public function payment($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('frontend.checkout.payment', compact('order'));
    }

    public function manualPayment($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('frontend.checkout.manual-payment', compact('order'));
    }

    public function success($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('frontend.checkout.success', compact('order'));
    }

    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'notes' => 'nullable|string|max:1000',
        ]);

        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status !== 'pending_payment') {
            return redirect()->back()->with('error', 'Pesanan ini sudah tidak dapat diubah statusnya');
        }

        try {
            // Store payment proof
            $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

            // Update order
            $order->update([
                'payment_proof' => $proofPath,
                'payment_notes' => $request->notes,
                'status' => 'payment_verification',
            ]);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload. Tim kami akan memverifikasi dalam 24 jam.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload bukti pembayaran. Silakan coba lagi.');
        }
    }
}
