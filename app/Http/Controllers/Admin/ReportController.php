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
            // MySQL compatible: use YEAR() and MONTH()
            $data = Order::where('status', 'completed')
                ->whereRaw("YEAR(created_at) = ?", [$year])
                ->selectRaw("MONTH(created_at) as month, SUM(total_amount) as revenue, COUNT(*) as orders")
                ->groupByRaw("MONTH(created_at)")
                ->orderByRaw("MONTH(created_at)")
                ->get();
        } else {
            // MySQL compatible: use YEAR() and WEEK()
            $data = Order::where('status', 'completed')
                ->whereRaw("YEAR(created_at) = ?", [$year])
                ->selectRaw("WEEK(created_at) as week, SUM(total_amount) as revenue, COUNT(*) as orders")
                ->groupByRaw("WEEK(created_at)")
                ->orderByRaw("WEEK(created_at)")
                ->get();
        }

        $totalRevenue = $data->sum('revenue');
        $totalOrders = $data->sum('orders');

        return view('admin.reports.financial', compact('data', 'period', 'year', 'totalRevenue', 'totalOrders'));
    }

    private function getReportData($period, $year)
    {
        if ($period === 'monthly') {
            // MySQL compatible: use YEAR() and MONTH()
            return Order::where('status', 'completed')
                ->whereRaw("YEAR(created_at) = ?", [$year])
                ->selectRaw("MONTH(created_at) as month, SUM(total_amount) as revenue, COUNT(*) as orders")
                ->groupByRaw("MONTH(created_at)")
                ->orderByRaw("MONTH(created_at)")
                ->get();
        } else {
            // MySQL compatible: use YEAR() and WEEK()
            return Order::where('status', 'completed')
                ->whereRaw("YEAR(created_at) = ?", [$year])
                ->selectRaw("WEEK(created_at) as week, SUM(total_amount) as revenue, COUNT(*) as orders")
                ->groupByRaw("WEEK(created_at)")
                ->orderByRaw("WEEK(created_at)")
                ->get();
        }
    }
}
