<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Summary data
        $summary = [
            'total_revenue' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'completed')
                ->sum('total_price'),
            'total_orders' => Order::whereBetween('created_at', [$startDate, $endDate])->count(),
            'new_customers' => User::whereBetween('created_at', [$startDate, $endDate])
                ->where('role', 'customer')
                ->count(),
            'products_sold' => Order::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'completed')
                ->with('items')
                ->get()
                ->sum(function($order) {
                    return $order->items->sum('quantity');
                })
        ];

        // Chart data (last 7 days)
        $chartData = $this->getChartData($startDate, $endDate);

        // Top products
        $topProducts = Product::with('category')
            ->whereHas('orderItems', function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($orderQuery) use ($startDate, $endDate) {
                    $orderQuery->whereBetween('created_at', [$startDate, $endDate])
                        ->where('status', 'completed');
                });
            })
            ->withCount(['orderItems as total_sold' => function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($orderQuery) use ($startDate, $endDate) {
                    $orderQuery->whereBetween('created_at', [$startDate, $endDate])
                        ->where('status', 'completed');
                });
            }])
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Recent orders
        $recentOrders = Order::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.reports.index', compact('summary', 'chartData', 'topProducts', 'recentOrders'));
    }

    private function getChartData($startDate, $endDate)
    {
        $days = [];
        $revenue = [];
        $orders = [];

        $currentDate = \Carbon\Carbon::parse($startDate);
        $endDate = \Carbon\Carbon::parse($endDate);

        while ($currentDate->lte($endDate)) {
            $dayStart = $currentDate->copy()->startOfDay();
            $dayEnd = $currentDate->copy()->endOfDay();

            $dayRevenue = Order::whereBetween('created_at', [$dayStart, $dayEnd])
                ->where('status', 'completed')
                ->sum('total_price');

            $dayOrders = Order::whereBetween('created_at', [$dayStart, $dayEnd])->count();

            $days[] = $currentDate->format('d M');
            $revenue[] = $dayRevenue;
            $orders[] = $dayOrders;

            $currentDate->addDay();
        }

        return [
            'labels' => $days,
            'revenue' => $revenue,
            'orders' => $orders
        ];
    }
}
