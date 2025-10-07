<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Payment status filter
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function acceptPayment(Order $order)
    {
        if ($order->status === 'pending' && $order->payment_status === 'paid') {
            $order->update([
                'status' => 'processing'
            ]);

            // Reduce stock for each item
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                    $product->increment('sales_count', $item->quantity);
                }
            }

            return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi dan pesanan diproses');
        }

        return redirect()->back()->with('error', 'Pesanan tidak dapat dikonfirmasi');
    }

    public function rejectPayment(Order $order)
    {
        if ($order->status === 'pending') {
            $order->update([
                'status' => 'cancelled',
                'payment_status' => 'failed'
            ]);

            return redirect()->back()->with('success', 'Pembayaran ditolak dan pesanan dibatalkan');
        }

        return redirect()->back()->with('error', 'Pesanan tidak dapat ditolak');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
            'tracking_number' => 'nullable|string|max:255'
        ]);

        $order->update([
            'status' => $request->status,
            'tracking_number' => $request->tracking_number
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
    }
}