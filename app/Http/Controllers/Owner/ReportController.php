<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $period = request('period', 'monthly');
        $year = request('year', date('Y'));
        
        $revenue = $this->getRevenueData($period, $year);
        $customerGrowth = User::where('role', 'customer')
                             ->whereYear('created_at', $year)
                             ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                             ->groupByRaw('MONTH(created_at)')
                             ->get();
        
        return view('owner.reports.index', compact('revenue', 'customerGrowth', 'period', 'year'));
    }
    
    public function customerReport()
    {
        $customers = User::where('role', 'customer')
                         ->withCount('orders')
                         ->paginate(15);
        
        return view('owner.reports.customers', compact('customers'));
    }

    public function exportCsv(Request $request)
    {
        $year = $request->year ?? date('Y');
        $fileName = 'laporan_keuangan_' . $year . '.csv';

        // Ambil data transaksi
        $orders = Order::with('user')
            ->whereYear('created_at', $year)
            ->where('status', 'completed')
            ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Header Kolom CSV
            fputcsv($file, ['No Invoice', 'Tanggal', 'Customer', 'Total Belanja', 'Status']);

            // Isi Data
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->invoice_number,
                    $order->created_at->format('Y-m-d H:i'),
                    $order->user->name ?? 'Guest',
                    $order->total_amount,
                    $order->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    private function getRevenueData($period, $year)
    {
        $labels = [];
        $revenues = [];
        $orders = [];

        if ($period === 'monthly') {
            // 1. Siapkan kerangka data kosong (Januari - Desember)
            for ($i = 1; $i <= 12; $i++) {
                $date = Carbon::createFromDate($year, $i, 1);
                $labels[] = $date->translatedFormat('F'); // Januari, Februari, dst
                $revenues[$i] = 0; // Default value 0
                $orders[$i] = 0;
            }

            // 2. Ambil Data Real dari Database (Hanya yang Completed)
            $data = Order::where('status', 'completed')
                ->whereYear('created_at', $year)
                ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue, COUNT(*) as total_order')
                ->groupByRaw('MONTH(created_at)')
                ->get();

            // 3. Timpa data kosong dengan data real
            foreach ($data as $row) {
                $revenues[$row->month] = (float) $row->revenue;
                $orders[$row->month] = (int) $row->total_order;
            }
        } else {
            // Weekly logic (simplified)
            $startDate = Carbon::createFromDate($year, 1, 1);
            $endDate = Carbon::createFromDate($year, 12, 31);
            
            for ($date = $startDate; $date <= $endDate; $date->addWeek()) {
                $week = $date->weekOfYear;
                $labels[] = "Week " . $week;
                $revenues[$week] = 0;
                $orders[$week] = 0;
            }

            $data = Order::where('status', 'completed')
                ->whereYear('created_at', $year)
                ->selectRaw('WEEK(created_at) as week, SUM(total_amount) as revenue, COUNT(*) as total_order')
                ->groupByRaw('WEEK(created_at)')
                ->get();

            foreach ($data as $row) {
                $revenues[$row->week] = (float) $row->revenue;
                $orders[$row->week] = (int) $row->total_order;
            }
        }
        
        // Return array yang bersih dan urut untuk Chart.js
        return [
            'labels' => $labels,
            'revenue_data' => array_values($revenues),
            'order_data' => array_values($orders),
            'total_revenue' => array_sum($revenues)
        ];
    }
}
