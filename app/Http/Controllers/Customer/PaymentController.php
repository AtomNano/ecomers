<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show($orderId)
    {
        $order = Order::with(['items.product', 'payment'])->findOrFail($orderId);
        
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $payment = $order->payment;
        
        return view('customer.payment.show', compact('order', 'payment'));
    }

    public function uploadProof(Request $request, $orderId)
    {
        $order = Order::with('payment')->findOrFail($orderId);
        
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'proof_image' => 'required|image|max:2048'
        ]);
        
        $path = $request->file('proof_image')->store('payments', 'public');
        
        $order->payment->update([
            'proof_image' => $path,
            'paid_at' => now(),
            'status' => 'pending'
        ]);
        
        return redirect()->route('customer.payment.status', $order->id)
                       ->with('success', 'Bukti pembayaran berhasil dikirim');
    }

    public function status($orderId)
    {
        $order = Order::with(['items.product', 'payment'])->findOrFail($orderId);
        
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('customer.payment.status', compact('order'));
    }
}
