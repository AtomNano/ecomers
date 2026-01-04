<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $lowStockProducts = Product::where('stock', '<=', 'min_stock')->count();
        
        $recentOrders = Order::with('user', 'payment')->latest()->limit(5)->get();
        
        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingPayments',
            'shippedOrders',
            'completedOrders',
            'totalRevenue',
            'lowStockProducts',
            'recentOrders'
        ));
    }
}
