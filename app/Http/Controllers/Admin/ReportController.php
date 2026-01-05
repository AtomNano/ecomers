<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $period = request('period', 'monthly');
        $year = request('year', date('Y'));
        
        $data = $this->getReportData($period, $year);
        
        return view('admin.reports.index', compact('data', 'period', 'year'));
    }
    
    public function financialReport()
    {
        $period = request('period', 'monthly');
        $year = request('year', date('Y'));
        
        if ($period === 'monthly') {
            // SQLite compatible: use strftime instead of MONTH()
            $data = Order::where('status', 'completed')
                        ->whereRaw("strftime('%Y', created_at) = ?", [$year])
                        ->selectRaw("CAST(strftime('%m', created_at) AS INTEGER) as month, SUM(total_amount) as revenue, COUNT(*) as orders")
                        ->groupByRaw("strftime('%m', created_at)")
                        ->orderByRaw("strftime('%m', created_at)")
                        ->get();
        } else {
            // SQLite compatible: use strftime instead of WEEK()
            $data = Order::where('status', 'completed')
                        ->whereRaw("strftime('%Y', created_at) = ?", [$year])
                        ->selectRaw("CAST(strftime('%W', created_at) AS INTEGER) as week, SUM(total_amount) as revenue, COUNT(*) as orders")
                        ->groupByRaw("strftime('%W', created_at)")
                        ->orderByRaw("strftime('%W', created_at)")
                        ->get();
        }
        
        $totalRevenue = $data->sum('revenue');
        $totalOrders = $data->sum('orders');
        
        return view('admin.reports.financial', compact('data', 'period', 'year', 'totalRevenue', 'totalOrders'));
    }
    
    private function getReportData($period, $year)
    {
        if ($period === 'monthly') {
            // SQLite compatible: use strftime instead of MONTH()
            return Order::where('status', 'completed')
                       ->whereRaw("strftime('%Y', created_at) = ?", [$year])
                       ->selectRaw("CAST(strftime('%m', created_at) AS INTEGER) as month, SUM(total_amount) as revenue, COUNT(*) as orders")
                       ->groupByRaw("strftime('%m', created_at)")
                       ->orderByRaw("strftime('%m', created_at)")
                       ->get();
        } else {
            // SQLite compatible: use strftime instead of WEEK()
            return Order::where('status', 'completed')
                       ->whereRaw("strftime('%Y', created_at) = ?", [$year])
                       ->selectRaw("CAST(strftime('%W', created_at) AS INTEGER) as week, SUM(total_amount) as revenue, COUNT(*) as orders")
                       ->groupByRaw("strftime('%W', created_at)")
                       ->orderByRaw("strftime('%W', created_at)")
                       ->get();
        }
    }
}
