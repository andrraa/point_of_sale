<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Stock;
use Illuminate\View\View;

class DashboardController
{
    public function __invoke(): View
    {
        $stocks = Stock::limit(10)
            ->where('stock_out', '>', 0)
            ->orderBy('stock_out', 'desc')
            ->get();

        $sales = Sale::limit(10)
            ->where('sales_status', Sale::PAID_STATUS)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact(['stocks', 'sales']));
    }
}
