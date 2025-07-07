<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Models\Category;
use App\Models\Stock;
use App\Models\StockLog;
use App\Services\ValidationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                    'stock_in',
                    'stock_out',
                    'stock_category_id',
                    'stock_purchase_price'
                ]);

            if ($request->filled('category_id')) {
                $stocks->where('stock_category_id', $request->category_id);
            }

            $totalStockAll = (clone $stocks)->sum('stock_total');
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
                    'reset' => route('stock.reset', $stock->stock_id),
                    'log' => route('stock.log', $stock->stock_id),
                ])
                ->with([
                    'total_stock_all' => $totalStockAll,
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

        $stocks = Stock::with('category')
            ->when($category !== 'all', function ($query) use ($category) {
                $query->where('stock_category_id', $category);
            })
            ->get()
            ->groupBy('stock_category_id');

        $pdf = Pdf::loadView(
            'stock.report',
            compact(['stocks'])
        )
            ->setPaper('a4', 'portrait');

        return $pdf->download("LAPORAN-STOK.pdf");
    }
}
