<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function acceptPayment(Order $order)
    {
        $order->update([
            'payment_status' => 'accepted',
            'status' => 'processing',
        ]);

        return redirect()->back()->with('success', 'Pembayaran diterima');
    }

    public function rejectPayment(Order $order)
    {
        $order->update([
            'payment_status' => 'rejected',
            'status' => 'cancelled',
        ]);

        return redirect()->back()->with('success', 'Pembayaran ditolak');
    }
}

