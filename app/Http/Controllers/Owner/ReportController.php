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

class ReportController extends Controller
{
    public function index()
    {
        return view('owner.reports.index');
    }

    public function sales(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'export' => 'nullable|in:excel,csv'
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->subMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : now();

        // Query untuk laporan penjualan
        $salesData = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_amount) as total_revenue'),
                DB::raw('AVG(total_amount) as average_order_value')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Statistik ringkasan
        $summary = [
            'total_orders' => $salesData->sum('total_orders'),
            'total_revenue' => $salesData->sum('total_revenue'),
            'average_order_value' => $salesData->avg('average_order_value'),
            'best_day' => $salesData->sortByDesc('total_revenue')->first(),
            'worst_day' => $salesData->sortBy('total_revenue')->first(),
        ];

        // Laporan penjualan per kategori
        $categorySales = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name as category_name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_revenue')
            ->get();

        // Laporan penjualan per produk
        $productSales = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name',
                'products.sku',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('total_revenue')
            ->limit(20)
            ->get();

        // Laporan pelanggan
        $customerStats = User::where('role', 'customer')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('COUNT(*) as new_customers'),
                DB::raw('DATE(created_at) as date')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Top customers
        $topCustomers = User::where('role', 'customer')
            ->withSum(['orders' => function($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
            }], 'total_amount')
            ->withCount(['orders' => function($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->having('orders_sum_total_amount', '>', 0)
            ->orderByDesc('orders_sum_total_amount')
            ->limit(10)
            ->get();

        if ($request->export === 'excel') {
            return $this->exportSalesToExcel($salesData, $summary, $categorySales, $productSales, $startDate, $endDate);
        } elseif ($request->export === 'csv') {
            return $this->exportSalesToCSV($salesData, $summary, $categorySales, $productSales, $startDate, $endDate);
        }

        return view('owner.reports.sales', compact(
            'salesData',
            'summary',
            'categorySales',
            'productSales',
            'customerStats',
            'topCustomers',
            'startDate',
            'endDate'
        ));
    }

    public function products(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category_id' => 'nullable|exists:categories,id',
            'export' => 'nullable|in:excel,csv'
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->subMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : now();

        $query = Product::with('category');

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Produk terlaris
        $bestSellingProducts = $query->clone()
            ->withSum(['orderItems' => function($q) use ($startDate, $endDate) {
                $q->whereHas('order', function($orderQuery) use ($startDate, $endDate) {
                    $orderQuery->where('status', 'completed')
                               ->whereBetween('created_at', [$startDate, $endDate]);
                });
            }], 'quantity')
            ->withSum(['orderItems' => function($q) use ($startDate, $endDate) {
                $q->whereHas('order', function($orderQuery) use ($startDate, $endDate) {
                    $orderQuery->where('status', 'completed')
                               ->whereBetween('created_at', [$startDate, $endDate]);
                });
            }], 'price')
            ->orderByDesc('order_items_sum_quantity')
            ->limit(20)
            ->get();

        // Produk dengan penjualan terendah
        $worstSellingProducts = $query->clone()
            ->withSum(['orderItems' => function($q) use ($startDate, $endDate) {
                $q->whereHas('order', function($orderQuery) use ($startDate, $endDate) {
                    $orderQuery->where('status', 'completed')
                               ->whereBetween('created_at', [$startDate, $endDate]);
                });
            }], 'quantity')
            ->orderBy('order_items_sum_quantity')
            ->limit(20)
            ->get();

        // Produk dengan stok rendah
        $lowStockProducts = Product::where('stock', '<', 10)
            ->orderBy('stock')
            ->get();

        // Produk yang belum pernah terjual
        $unsoldProducts = Product::whereDoesntHave('orderItems', function($query) use ($startDate, $endDate) {
            $query->whereHas('order', function($orderQuery) use ($startDate, $endDate) {
                $orderQuery->where('status', 'completed')
                           ->whereBetween('created_at', [$startDate, $endDate]);
            });
        })->get();

        // Statistik kategori
        $categories = Category::withCount('products')
            ->withSum(['products' => function($query) use ($startDate, $endDate) {
                $query->whereHas('orderItems', function($q) use ($startDate, $endDate) {
                    $q->whereHas('order', function($orderQuery) use ($startDate, $endDate) {
                        $orderQuery->where('status', 'completed')
                                   ->whereBetween('created_at', [$startDate, $endDate]);
                    });
                });
            }], 'sales_count')
            ->get();

        if ($request->export === 'excel') {
            return $this->exportProductsToExcel($bestSellingProducts, $worstSellingProducts, $lowStockProducts, $unsoldProducts, $startDate, $endDate);
        } elseif ($request->export === 'csv') {
            return $this->exportProductsToCSV($bestSellingProducts, $worstSellingProducts, $lowStockProducts, $unsoldProducts, $startDate, $endDate);
        }

        return view('owner.reports.products', compact(
            'bestSellingProducts',
            'worstSellingProducts',
            'lowStockProducts',
            'unsoldProducts',
            'categories',
            'startDate',
            'endDate'
        ));
    }

    public function customers(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'export' => 'nullable|in:excel,csv'
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : now()->subMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : now();

        // Statistik pelanggan
        $customerStats = [
            'total_customers' => User::where('role', 'customer')->count(),
            'new_customers' => User::where('role', 'customer')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'active_customers' => User::where('role', 'customer')
                ->whereHas('orders', function($query) use ($startDate, $endDate) {
                    $query->where('status', 'completed')
                          ->whereBetween('created_at', [$startDate, $endDate]);
                })
                ->count(),
            'total_revenue' => Order::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_amount'),
        ];

        // Top customers berdasarkan total belanja
        $topCustomersBySpending = User::where('role', 'customer')
            ->withSum(['orders' => function($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
            }], 'total_amount')
            ->withCount(['orders' => function($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->orderByDesc('orders_sum_total_amount')
            ->limit(20)
            ->get();

        // Top customers berdasarkan frekuensi pembelian
        $topCustomersByFrequency = User::where('role', 'customer')
            ->withCount(['orders' => function($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->withSum(['orders' => function($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
            }], 'total_amount')
            ->orderByDesc('orders_count')
            ->limit(20)
            ->get();

        // Customer segmentation
        $customerSegmentation = [
            'vip' => User::where('role', 'customer')
                ->withSum('orders', 'total_amount')
                ->having('orders_sum_total_amount', '>=', 1000000)
                ->count(),
            'regular' => User::where('role', 'customer')
                ->withSum('orders', 'total_amount')
                ->having('orders_sum_total_amount', '>=', 100000)
                ->having('orders_sum_total_amount', '<', 1000000)
                ->count(),
            'new' => User::where('role', 'customer')
                ->withSum('orders', 'total_amount')
                ->having('orders_sum_total_amount', '<', 100000)
                ->count(),
        ];

        // Customer acquisition per bulan
        $customerAcquisition = User::where('role', 'customer')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as new_customers')
            )
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        if ($request->export === 'excel') {
            return $this->exportCustomersToExcel($customerStats, $topCustomersBySpending, $topCustomersByFrequency, $customerSegmentation, $startDate, $endDate);
        } elseif ($request->export === 'csv') {
            return $this->exportCustomersToCSV($customerStats, $topCustomersBySpending, $topCustomersByFrequency, $customerSegmentation, $startDate, $endDate);
        }

        return view('owner.reports.customers', compact(
            'customerStats',
            'topCustomersBySpending',
            'topCustomersByFrequency',
            'customerSegmentation',
            'customerAcquisition',
            'startDate',
            'endDate'
        ));
    }

    private function exportSalesToExcel($salesData, $summary, $categorySales, $productSales, $startDate, $endDate)
    {
        // Implementation for Excel export
        // This would require Laravel Excel package
        return response()->json(['message' => 'Excel export not implemented yet']);
    }

    private function exportSalesToCSV($salesData, $summary, $categorySales, $productSales, $startDate, $endDate)
    {
        $filename = 'sales_report_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($salesData, $summary, $categorySales, $productSales) {
            $file = fopen('php://output', 'w');
            
            // Summary
            fputcsv($file, ['LAPORAN PENJUALAN - RINGKASAN']);
            fputcsv($file, ['Total Pesanan', $summary['total_orders']]);
            fputcsv($file, ['Total Pendapatan', 'Rp ' . number_format($summary['total_revenue'], 0, ',', '.')]);
            fputcsv($file, ['Rata-rata Nilai Pesanan', 'Rp ' . number_format($summary['average_order_value'], 0, ',', '.')]);
            fputcsv($file, []);
            
            // Daily sales
            fputcsv($file, ['LAPORAN PENJUALAN HARIAN']);
            fputcsv($file, ['Tanggal', 'Total Pesanan', 'Total Pendapatan', 'Rata-rata Nilai Pesanan']);
            foreach ($salesData as $sale) {
                fputcsv($file, [
                    $sale->date,
                    $sale->total_orders,
                    'Rp ' . number_format($sale->total_revenue, 0, ',', '.'),
                    'Rp ' . number_format($sale->average_order_value, 0, ',', '.')
                ]);
            }
            fputcsv($file, []);
            
            // Category sales
            fputcsv($file, ['LAPORAN PENJUALAN PER KATEGORI']);
            fputcsv($file, ['Kategori', 'Total Kuantitas', 'Total Pendapatan']);
            foreach ($categorySales as $category) {
                fputcsv($file, [
                    $category->category_name,
                    $category->total_quantity,
                    'Rp ' . number_format($category->total_revenue, 0, ',', '.')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportProductsToExcel($bestSellingProducts, $worstSellingProducts, $lowStockProducts, $unsoldProducts, $startDate, $endDate)
    {
        return response()->json(['message' => 'Excel export not implemented yet']);
    }

    private function exportProductsToCSV($bestSellingProducts, $worstSellingProducts, $lowStockProducts, $unsoldProducts, $startDate, $endDate)
    {
        $filename = 'products_report_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($bestSellingProducts, $worstSellingProducts, $lowStockProducts, $unsoldProducts) {
            $file = fopen('php://output', 'w');
            
            // Best selling products
            fputcsv($file, ['PRODUK TERLARIS']);
            fputcsv($file, ['Nama Produk', 'SKU', 'Kategori', 'Total Terjual', 'Total Pendapatan']);
            foreach ($bestSellingProducts as $product) {
                fputcsv($file, [
                    $product->name,
                    $product->sku ?? '-',
                    $product->category->name,
                    $product->order_items_sum_quantity ?? 0,
                    'Rp ' . number_format($product->order_items_sum_price ?? 0, 0, ',', '.')
                ]);
            }
            fputcsv($file, []);
            
            // Low stock products
            fputcsv($file, ['PRODUK STOK RENDAH']);
            fputcsv($file, ['Nama Produk', 'SKU', 'Kategori', 'Stok Tersisa']);
            foreach ($lowStockProducts as $product) {
                fputcsv($file, [
                    $product->name,
                    $product->sku ?? '-',
                    $product->category->name,
                    $product->stock
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportCustomersToExcel($customerStats, $topCustomersBySpending, $topCustomersByFrequency, $customerSegmentation, $startDate, $endDate)
    {
        return response()->json(['message' => 'Excel export not implemented yet']);
    }

    private function exportCustomersToCSV($customerStats, $topCustomersBySpending, $topCustomersByFrequency, $customerSegmentation, $startDate, $endDate)
    {
        $filename = 'customers_report_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($customerStats, $topCustomersBySpending, $topCustomersByFrequency, $customerSegmentation) {
            $file = fopen('php://output', 'w');
            
            // Customer stats
            fputcsv($file, ['LAPORAN PELANGGAN - RINGKASAN']);
            fputcsv($file, ['Total Pelanggan', $customerStats['total_customers']]);
            fputcsv($file, ['Pelanggan Baru', $customerStats['new_customers']]);
            fputcsv($file, ['Pelanggan Aktif', $customerStats['active_customers']]);
            fputcsv($file, ['Total Pendapatan', 'Rp ' . number_format($customerStats['total_revenue'], 0, ',', '.')]);
            fputcsv($file, []);
            
            // Top customers by spending
            fputcsv($file, ['TOP PELANGGAN BERDASARKAN TOTAL BELANJA']);
            fputcsv($file, ['Nama', 'Email', 'Total Belanja', 'Jumlah Pesanan']);
            foreach ($topCustomersBySpending as $customer) {
                fputcsv($file, [
                    $customer->name,
                    $customer->email,
                    'Rp ' . number_format($customer->orders_sum_total_amount ?? 0, 0, ',', '.'),
                    $customer->orders_count ?? 0
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}



