<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class StockLogController
{
    public function index(Request $request, Stock $stock): View|JsonResponse
    {
        if (request()->ajax()) {
            $startDate = $request->input('start_date') ?: now()->toDateString();
            $endDate = $request->input('end_date') ?: now()->toDateString();

            $logs = StockLog::with(['stock', 'user'])
                ->where('stock_log_stock_id', $stock->stock_id)
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->orderByDesc('created_at');

            $totalQuantityOut = (clone $logs)
                ->where('stock_log_status', StockLog::OUT_STATUS)
                ->sum('stock_log_quantity');
            $totalQuantityIn = (clone $logs)
                ->where('stock_log_status', StockLog::IN_STATUS)
                ->sum('stock_log_quantity');

            return DataTables::of($logs)
                ->addIndexColumn()
                ->escapeColumns()
                ->with([
                    'total_quantity_out' => $totalQuantityOut,
                    'total_quantity_in' => $totalQuantityIn
                ])
                ->toJson();
        }

        return view('stock.log.index', compact('stock'));
    }
}
