<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'new_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                ->where('status', 'completed')
                ->sum('total_price'),
            'total_customers' => User::where('role', 'customer')->count(),
            'low_stock_products' => Product::where('stock', '<', 5)->count(),
        ];

        // Get recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        // Get top products
        $topProducts = Product::orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();

        // Get pending orders count for sidebar
        $pendingOrdersCount = Order::where('status', 'pending')->count();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts', 'pendingOrdersCount'));
    }
}