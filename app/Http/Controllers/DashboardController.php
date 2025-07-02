<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController
{
    public function __invoke(): View
    {
        return view('dashboard');
    }
}
