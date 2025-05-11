<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController
{
    public function __invoke(): View
    {
        return view('report.index');
    }
}
