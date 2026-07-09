<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController
{
    public function __invoke(): View
    {
        $today = Carbon::today();

        $revenueToday = Sale::whereDate('created_at', $today)
            ->whereIn('sales_status', [Sale::PAID_STATUS, Sale::CREDIT_STATUS])
            ->sum('sales_total_price');

        $salesCountToday = Sale::whereDate('created_at', $today)
            ->whereIn('sales_status', [Sale::PAID_STATUS, Sale::CREDIT_STATUS])
            ->count();

        $totalDebt = Sale::where('sales_status', Sale::CREDIT_STATUS)
            ->sum('sale_total_debt');

        $totalStockItems = Stock::sum('stock_total');

        $lowStockCount = Stock::where('stock_total', '<=', 5)
            ->where('stock_total', '>', 0)
            ->count();

        $totalCustomers = Customer::count();

        $stocks = Stock::where('stock_out', '>', 0)
            ->orderBy('stock_out', 'desc')
            ->limit(10)
            ->get();

        $sales = Sale::where('sales_status', Sale::PAID_STATUS)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $lowStocks = Stock::where('stock_total', '<=', 5)
            ->where('stock_total', '>', 0)
            ->orderBy('stock_total')
            ->limit(5)
            ->get();

        return view('dashboard', compact([
            'revenueToday',
            'salesCountToday',
            'totalDebt',
            'totalStockItems',
            'lowStockCount',
            'totalCustomers',
            'stocks',
            'sales',
            'lowStocks',
        ]));
    }
}
