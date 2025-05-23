<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Stock;
use Illuminate\View\View;

class CashierController
{
    public function index(): View
    {
        $customers = Customer::getCustomerDropdown();
        $stocks = Stock::getConcatedStockDropdown();

        return view('cashier.index', compact(['customers', 'stocks']));
    }
}
