<?php

namespace App\Http\Controllers\Owner;

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
            'total_revenue' => Order::where('status', 'completed')->sum('total_price'),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
        ];

        // Get chart data (last 30 days)
        $chartData = $this->getChartData();

        // Get recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        // Get top customers
        $topCustomers = User::where('role', 'customer')
            ->with(['customerGroup', 'orders'])
            ->withCount('orders')
            ->withSum('orders as total_spent', 'total_price')
            ->orderBy('total_spent', 'desc')
            ->limit(5)
            ->get();

        return view('owner.dashboard', compact('stats', 'chartData', 'recentOrders', 'topCustomers'));
    }

    private function getChartData()
    {
        $days = [];
        $revenue = [];
        $customers = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayStart = $date->copy()->startOfDay();
            $dayEnd = $date->copy()->endOfDay();

            $dayRevenue = Order::whereBetween('created_at', [$dayStart, $dayEnd])
                ->where('status', 'completed')
                ->sum('total_price');

            $dayCustomers = User::whereBetween('created_at', [$dayStart, $dayEnd])
                ->where('role', 'customer')
                ->count();

            $days[] = $date->format('d M');
            $revenue[] = $dayRevenue;
            $customers[] = $dayCustomers;
        }

        return [
            'labels' => $days,
            'revenue' => $revenue,
            'customers' => $customers
        ];
    }
}