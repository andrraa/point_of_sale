<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardController
{
    public function __invoke(): RedirectResponse
    {
        return redirect()->route('cashier');
    }
}
