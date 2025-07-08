<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleReportRequest;
use App\Http\Requests\SaleRequest;
use App\Models\Sale;
use App\Services\ValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class SaleController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date') ?: now()->toDateString();
            $endDate = $request->input('end_date') ?: now()->toDateString();

            $sales = Sale::with(
                [
                    'details',
                    'customer',
                    'credit'
                ]
            )->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->orderByDesc('created_at');

            $totalPrice = (clone $sales)->sum('sales_total_payment');
            $totalPayment = (clone $sales)->sum('sales_total_payment');
            $totalDebt = (clone $sales)->sum('sale_total_debt');

            return DataTables::of($sales)
                ->addIndexColumn()
                ->escapeColumns()
                ->addColumn('actions', function ($sale) {
                    $actions = [];

                    if ($sale->sales_status != Sale::CANCEL_STATUS) {
                        $actions['edit'] = route('sale.edit', $sale->sales_id);
                        $actions['delete'] = route('sale.destroy', $sale->sales_id);
                        $actions['print'] = $sale->sales_id;
                        $actions['detail'] = route('sale.show', $sale->sales_id);
                    }

                    return $actions;
                })
                ->with([
                    'total_price' => $totalPrice,
                    'total_payment' => $totalPayment,
                    'total_debt' => $totalDebt
                ])
                ->toJson();
        }

        return view('sale.index');
    }

    public function edit(Sale $sale): View
    {
        $sale->load(['details']);

        return view('sale.edit', compact('sale'));
    }

    public function show(Sale $sale): View
    {
        $sale->load(['details', 'customer']);

        return view('sale._print', compact('sale'));
    }

    public function destroy(Sale $sale): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        $sale->load('details.stock');

        DB::beginTransaction();

        foreach ($sale->details as $detail) {
            $stock = $detail->stock;

            $stockOut = $stock->stock_out - $detail->sale_detail_quantity;

            $stock->update([
                'stock_out' => $stockOut
            ]);
        }

        $sale->update([
            'sales_status' => Sale::CANCEL_STATUS
        ]);

        DB::commit();

        return response()->json(true);
    }

    public function detail(Sale $sale): View
    {
        return view('sale.show', compact('sale'));
    }

    public function report(SaleReportRequest $request)
    {
        $validated = $request->validated();
    }
}
