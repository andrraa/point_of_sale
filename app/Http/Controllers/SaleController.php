<?php

namespace App\Http\Controllers;

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
            $sales = Sale::with(['details', 'customer', 'credit']);

            return DataTables::of($sales)
                ->addIndexColumn()
                ->escapeColumns()
                ->addColumn('actions', function ($sale) {
                    $actions = [];

                    if ($sale->sales_status != Sale::CANCEL_STATUS) {
                        $actions['delete'] = route('sale.destroy', $sale->sales_id);
                        $actions['print'] = $sale->sales_id;
                    }

                    return $actions;
                })
                ->toJson();
        }

        return view('sale.index');
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

            $stockCurrent = $stock->stock_current + $detail->sale_detail_quantity;
            $stockOut = $stock->stock_out - $detail->sale_detail_quantity;

            $stock->update([
                'stock_current' => $stockCurrent,
                'stock_out' => $stockOut
            ]);
        }

        $sale->update([
            'sales_status' => Sale::CANCEL_STATUS
        ]);

        DB::commit();

        return response()->json(true);
    }
}
