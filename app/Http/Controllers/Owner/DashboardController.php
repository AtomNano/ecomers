<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = User::where('role', 'customer')->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $pendingPayments = Payment::where('status', 'pending')->count();
        
        $recentCustomers = User::where('role', 'customer')->latest()->limit(5)->get();
        $recentOrders = Order::with('user', 'payment')->latest()->limit(5)->get();
        
        // Query Barang Terlaris (Top 5)
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function($q) {
                $q->where('status', 'completed');
            })
            ->with('product') // Eager load nama produk
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();
        
        return view('owner.dashboard', compact(
            'totalCustomers',
            'totalOrders',
            'totalRevenue',
            'pendingPayments',
            'recentCustomers',
            'recentOrders',
            'topProducts'
        ));
    }
}
