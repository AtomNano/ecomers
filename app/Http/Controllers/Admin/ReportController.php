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
        
        $data = $this->buildPeriodQuery($period, $year);
        
        $totalRevenue = $data->sum('revenue');
        $totalOrders = $data->sum('orders');
        
        return view('admin.reports.financial', compact('data', 'period', 'year', 'totalRevenue', 'totalOrders'));
    }
    
    private function getReportData($period, $year)
    {
        return $this->buildPeriodQuery($period, $year);
    }

    private function buildPeriodQuery(string $period, $year)
    {
        $parts = $this->dateParts();
        $groupExpr = $period === 'monthly' ? $parts['month'] : $parts['week'];
        $alias = $period === 'monthly' ? 'month' : 'week';

        return Order::where('status', 'completed')
            ->whereRaw("{$parts['year']} = ?", [$year])
            ->selectRaw("CAST($groupExpr AS {$parts['cast']}) as $alias, SUM(total_amount) as revenue, COUNT(*) as orders")
            ->groupByRaw($groupExpr)
            ->orderByRaw($groupExpr)
            ->get();
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
