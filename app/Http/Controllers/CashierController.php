<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CashierController
{
    public function index(): View
    {
        return view('cashier.index');
    }
}
