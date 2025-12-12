<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik umum
        $totalCustomers = User::where('role', 'customer')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        
        // Statistik pesanan
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending_payment')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        
        // Pendapatan
        $todayRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total_amount');
            
        $thisMonthRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
            
        $lastMonthRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_amount');
        
        // Grafik pendapatan 7 hari terakhir
        $revenueChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = Order::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('total_amount');
                
            $revenueChart[] = [
                'date' => $date->format('d M'),
                'revenue' => $revenue
            ];
        }
        
        // Grafik pendapatan 12 bulan terakhir
        $monthlyRevenueChart = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = Order::where('status', 'completed')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');
                
            $monthlyRevenueChart[] = [
                'month' => $date->format('M Y'),
                'revenue' => $revenue
            ];
        }
        
        // Produk terlaris
        $bestSellingProducts = Product::with('category')
            ->orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();
        
        // Produk dengan stok rendah
        $lowStockProducts = Product::where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();
        
        // Pelanggan terbaik (berdasarkan total belanja)
        $topCustomers = User::where('role', 'customer')
            ->withSum('orders', 'total_amount')
            ->orderBy('orders_sum_total_amount', 'desc')
            ->limit(5)
            ->get();
        
        // Pesanan terbaru
        $recentOrders = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Aktivitas terbaru (gabungan dari berbagai sumber)
        $recentActivities = collect();
        
        // Tambahkan pesanan baru
        $recentOrders->each(function ($order) use ($recentActivities) {
            $recentActivities->push([
                'type' => 'order',
                'message' => "Pesanan baru #{$order->order_number} dari {$order->user->name}",
                'time' => $order->created_at,
                'icon' => 'shopping-cart',
                'color' => 'blue'
            ]);
        });
        
        // Tambahkan produk baru
        $recentProducts = Product::orderBy('created_at', 'desc')->limit(5)->get();
        $recentProducts->each(function ($product) use ($recentActivities) {
            $recentActivities->push([
                'type' => 'product',
                'message' => "Produk baru: {$product->name}",
                'time' => $product->created_at,
                'icon' => 'package',
                'color' => 'green'
            ]);
        });
        
        // Tambahkan pelanggan baru
        $recentCustomers = User::where('role', 'customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $recentCustomers->each(function ($customer) use ($recentActivities) {
            $recentActivities->push([
                'type' => 'customer',
                'message' => "Pelanggan baru: {$customer->name}",
                'time' => $customer->created_at,
                'icon' => 'user',
                'color' => 'purple'
            ]);
        });
        
        // Urutkan berdasarkan waktu dan ambil 10 terbaru
        $recentActivities = $recentActivities->sortByDesc('time')->take(10);
        
        // Statistik per kategori
        $categoryStats = Category::withCount('products')
            ->withSum('products', 'sales_count')
            ->orderBy('products_sum_sales_count', 'desc')
            ->get();
        
        return view('owner.dashboard', compact(
            'totalCustomers',
            'totalAdmins', 
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'shippedOrders',
            'completedOrders',
            'todayRevenue',
            'thisMonthRevenue',
            'lastMonthRevenue',
            'revenueChart',
            'monthlyRevenueChart',
            'bestSellingProducts',
            'lowStockProducts',
            'topCustomers',
            'recentOrders',
            'recentActivities',
            'categoryStats'
        ));
    }
}