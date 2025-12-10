<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Models\Category;
use App\Models\Stock;
use App\Models\StockLog;
use App\Models\SupplierStock;
use App\Services\ValidationService;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class StockController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $category = $request->input('category_id');
            $rack = $request->input('rack_id');
            $supplier = $request->input('ss_id');

            $stocks = Stock::with(['category', 'rack', 'supplierStock'])
                ->select([
                    'tbl_stocks.stock_id',
                    'tbl_stocks.stock_code',
                    'tbl_stocks.stock_name',
                    'tbl_stocks.stock_total',
                    'tbl_stocks.stock_in',
                    'tbl_stocks.stock_out',
                    'tbl_stocks.stock_category_id',
                    'tbl_stocks.stock_rack_id',
                    'tbl_stocks.stock_purchase_price',
                    'tbl_stocks.stock_ss_id',
                    DB::raw("(stock_total + stock_out) AS stock_awal"),
                    DB::raw("
                        CASE 
                            WHEN stock_total < 0 THEN 0
                            ELSE stock_total
                        END AS stock_remaining
                    ")
                ])
                ->when(
                    $category !== 'all',
                    fn($q) => $q->where('stock_category_id', $category)
                )
                ->when(
                    $rack !== 'all',
                    fn($q) => $q->where('stock_rack_id', $rack)
                )
                ->when(
                    $supplier !== 'all',
                    fn($q) => $q->where('stock_ss_id', $supplier)
                );

            $totalStockAwal = (clone $stocks)->sum(DB::raw('stock_total + stock_out'));
            $totalStockAll = (clone $stocks)->sum('stock_total');
            $totalStockOut = (clone $stocks)->sum('stock_out');
            $totalStockPurchasePrice = Stock::when(
                    $category !== 'all',
                    fn($q) => $q->where('stock_category_id', $category)
                )
                ->selectRaw('SUM(stock_purchase_price * stock_total) AS total')
                ->value('total');
            $totalStockRemaining = Stock::when(
                    $category !== 'all',
                    fn($q) => $q->where('stock_category_id', $category)
                )
                ->selectRaw("SUM(stock_total) AS total_remaining")
                ->value('total_remaining');

            return DataTables::of($stocks)
                ->addIndexColumn()
                ->escapeColumns()
                ->addColumn('actions', fn($stock) => [
                    'edit' => route('stock.edit', $stock->stock_id),
                    'delete' => route('stock.destroy', $stock->stock_id),
                    'reset' => route('stock.reset', $stock->stock_id),
                    'log' => route('stock.log', $stock->stock_id),
                ])
                ->with([
                    'total_stock_all' => $totalStockAll,
                    'total_stock_out' => $totalStockOut,
                    'total_stock_purchase_price' => $totalStockPurchasePrice,
                    'total_stock_remaining' => $totalStockRemaining,
                    'total_stock_awal' => $totalStockAwal
                ])
                ->toJson();
        }

        $categories = Category::getItemCategories()->prepend('Semua Kategori', 'all');

        $racks = Category::getRackCategories()->prepend('Semua Rak', 'all');

        $suppliers = SupplierStock::getSupplierStockDropdown()->prepend('Semua Supplier', 'all');

        return view('stock.index', compact(['categories', 'racks', 'suppliers']));
    }

    public function create(): View
    {
        $validator = $this->validationService
            ->generateValidation(StockRequest::class, '#form-create-stock');

        $categories = Category::getItemCategories();

        $racks = Category::getRackCategories();

        $suppliers = SupplierStock::getSupplierStockDropdown();

        return view('stock.create', compact([
            'validator', 'categories', 'racks', 'suppliers'
        ]));
    }

    public function store(StockRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Stock::create($validated)
            ? flash()->preset('create_success')
            : flash()->preset('create_failed');

        return redirect()->route('stock.index');
    }

    public function edit(Stock $stock): View
    {
        $validator = $this->validationService
            ->generateValidation(StockRequest::class, '#form-edit-stock');

        $categories = Category::getItemCategories();

        $racks = Category::getRackCategories();

        $suppliers = SupplierStock::getSupplierStockDropdown();

        $state = 'edit';

        return view('stock.edit', compact(
            ['stock', 'validator', 'categories', 'state', 'racks', 'suppliers'
        ]));
    }

    public function update(StockRequest $request, Stock $stock): RedirectResponse
    {
        $validated = $request->validated();

        $user = Auth::user();

        $oldStockTotal = $stock->stock_total;

        $updated = $stock->update($validated);

        if ($updated) {
            if ($validated['stock_total'] !== $oldStockTotal) {
                $status = $validated['stock_total'] > $oldStockTotal
                    ? StockLog::IN_STATUS
                    : StockLog::OUT_STATUS;
                $difference = abs($validated['stock_total'] - $oldStockTotal);

                StockLog::create([
                    'stock_log_stock_id' => $stock->stock_id,
                    'stock_log_quantity' => $difference,
                    'stock_log_description' => 'Perubahan jumlah stok dari update',
                    'stock_log_status' => $status,
                    'stock_log_user_id' => $user->user_id,
                ]);

                flash()->preset('update_success');
            }
        } else {
            flash()->preset('update_failed');
        }

        return redirect()->route('stock.index');
    }

    public function destroy(Stock $stock): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        $result = $stock->delete();

        return response()->json($result ? true : false);
    }

    public function reset(Stock $stock): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        $stock->update([
            'stock_total' => 0,
        ]);

        return response()->json(true);
    }

    public function report(Request $request)
    {
        $category = $request->input('stock_category');

        $stocks = Stock::query()
            ->select([
                'id',
                'stock_code',
                'stock_name',
                'stock_total',
                'stock_out',
                'stock_in',
                'stock_purchase_price',
                'stock_category_id',
            ])
            ->with([
                'category:id,category_name',
            ])
            ->when(
                $category !== 'all',
                fn($q) => $q->where('stock_category_id', $category)
            )
            ->orderBy('stock_category_id')
            ->get()
            ->groupBy('stock_category_id');

        $pdf = PDF::loadView('stock.report', compact('stocks'))
            ->setPaper('a4')
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10)
            ->setOption('margin-right', 10);

        return $pdf->download("LAPORAN-STOK.pdf");
    }
}
