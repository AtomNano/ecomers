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
        $parts = $this->dateParts();
        $customerGrowth = User::where('role', 'customer')
                             ->whereRaw("{$parts['year']} = ?", [$year])
                             ->selectRaw("CAST({$parts['month']} AS {$parts['cast']}) as month, COUNT(*) as count")
                             ->groupByRaw($parts['month'])
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
            $parts = $this->dateParts();
            $data = Order::where('status', 'completed')
                ->whereRaw("{$parts['year']} = ?", [$year])
                ->selectRaw("CAST({$parts['month']} AS {$parts['cast']}) as month, SUM(total_amount) as revenue, COUNT(*) as total_order")
                ->groupByRaw($parts['month'])
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

            $parts = $this->dateParts();
            $data = Order::where('status', 'completed')
                ->whereRaw("{$parts['year']} = ?", [$year])
                ->selectRaw("CAST({$parts['week']} AS {$parts['cast']}) as week, SUM(total_amount) as revenue, COUNT(*) as total_order")
                ->groupByRaw($parts['week'])
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

    private function dateParts(): array
    {
        $connection = Order::query()->getModel()->getConnection();
        $driver = $connection->getDriverName();

        if ($driver === 'sqlite') {
            return [
                'year' => "strftime('%Y', created_at)",
                'month' => "strftime('%m', created_at)",
                'week' => "strftime('%W', created_at)",
                'cast' => 'INTEGER',
            ];
        }

        return [
            'year' => 'YEAR(created_at)',
            'month' => 'MONTH(created_at)',
            'week' => 'WEEK(created_at, 1)',
            'cast' => 'UNSIGNED',
        ];
    }
}
