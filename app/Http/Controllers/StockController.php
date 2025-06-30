<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Models\Category;
use App\Models\Stock;
use App\Services\ValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            $stocks = Stock::with('category')
                ->select([
                    'stock_id',
                    'stock_code',
                    'stock_name',
                    'stock_total',
                    'stock_current',
                    'stock_in',
                    'stock_out',
                    'stock_category_id',
                    'stock_purchase_price'
                ]);

            if ($request->filled('category_id')) {
                $stocks->where('stock_category_id', $request->category_id);
            }

            $totalStockAll = (clone $stocks)->sum('stock_total');
            $totalStockCurrent = (clone $stocks)->sum('stock_current');
            $totalStockOut = (clone $stocks)->sum('stock_out');
            $totalStockPurchasePrice = (new Stock)
                ->where('stock_category_id', $request->category_id)
                ->selectRaw('SUM(stock_purchase_price * stock_total) as total')
                ->value('total');

            return DataTables::of($stocks)
                ->addIndexColumn()
                ->escapeColumns()
                ->addColumn('actions', fn($stock) => [
                    'edit' => route('stock.edit', $stock->stock_id),
                    'delete' => route('stock.destroy', $stock->stock_id),
                    'reset' => route('stock.reset', $stock->stock_id)
                ])
                ->with([
                    'total_stock_all' => $totalStockAll,
                    'total_stock_current' => $totalStockCurrent,
                    'total_stock_out' => $totalStockOut,
                    'total_stock_purchase_price' => $totalStockPurchasePrice
                ])
                ->toJson();
        }

        $categories = Category::getItemCategories();

        return view('stock.index', compact('categories'));
    }

    public function create(): View
    {
        $validator = $this->validationService
            ->generateValidation(StockRequest::class, '#form-create-stock');

        $categories = Category::getItemCategories();

        return view('stock.create', compact(['validator', 'categories']));
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

        $state = 'edit';

        return view('stock.edit', compact(['stock', 'validator', 'categories', 'state']));
    }

    public function update(StockRequest $request, Stock $stock): RedirectResponse
    {
        $validated = $request->validated();

        $stock->update($validated)
            ? flash()->preset('update_success')
            : flash()->preset('update_failed');

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
            'stock_current' => 0,
            'stock_in' => 0,
            'stock_out' => 0
        ]);

        return response()->json(true);
    }
}
