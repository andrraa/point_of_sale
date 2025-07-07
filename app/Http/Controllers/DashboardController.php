<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\View\View;

class DashboardController
{
    public function __invoke(): View
    {
        $stocks = Stock::limit(10)
            ->orderBy('stock_out', 'desc')
            ->get();

        $sales = [];

        return view('dashboard', compact(['stocks', 'sales']));
    }
}
