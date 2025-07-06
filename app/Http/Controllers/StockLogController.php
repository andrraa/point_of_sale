<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockLog;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class StockLogController
{
    public function index(Stock $stock): View|JsonResponse
    {
        if (request()->ajax()) {
            $logs = StockLog::with(['stock', 'user'])
                ->where('stock_log_stock_id', $stock->stock_id);

            return DataTables::of($logs)
                ->addIndexColumn()
                ->escapeColumns()
                ->toJson();
        }

        return view('stock.log.index', compact('stock'));
    }
}
