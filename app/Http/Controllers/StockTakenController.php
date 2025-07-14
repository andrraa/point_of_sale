<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockTakenReportRequest;
use App\Http\Requests\StockTakenRequest;
use App\Models\Category;
use App\Models\Stock;
use App\Models\StockLog;
use App\Models\StockTaken;
use App\Services\ValidationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class StockTakenController
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

            $takens = StockTaken::with(['stock', 'user', 'category'])
                ->select([
                    'stock_taken_id',
                    'stock_taken_stock_code',
                    'stock_taken_stock_name',
                    'stock_taken_quantity',
                    'stock_taken_price',
                    'stock_taken_description',
                    'stock_taken_user_id',
                    'stock_taken_category_id',
                    'created_at'
                ])
                ->when(
                    $category !== 'all',
                    fn($q)
                    => $q->where('stock_taken_category_id', $category)
                );

            $totalStockAll = (clone $takens)->sum('stock_taken_quantity');
            $totalStockPurchasePrice = (new StockTaken())
                ->where('stock_taken_category_id', $request->category_id)
                ->selectRaw('SUM(stock_taken_price * stock_taken_quantity) as total')
                ->value('total');

            return DataTables::of($takens)
                ->addIndexColumn()
                ->escapeColumns()
                ->with([
                    'total_stock_all' => $totalStockAll,
                    'total_stock_purchase_price' => $totalStockPurchasePrice
                ])
                ->toJson();
        }

        $categories = Category::getItemCategories()->prepend('Semua Kategori', 'all');

        $validator = $this->validationService
            ->generateValidation(StockTakenRequest::class, '#form-stock-taken');
        $reportValidator = $this->validationService
            ->generateValidation(StockTakenReportRequest::class, '#form-report');

        return view('stock.taken.index', compact([
            'categories',
            'validator',
            'reportValidator'
        ]));
    }

    public function store(StockTakenRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validated();

        $stock = Stock::firstWhere('stock_code', $validated['stock_code']);

        $data = [
            'stock_taken_stock_id' => $stock->stock_id,
            'stock_taken_stock_code' => $stock->stock_code,
            'stock_taken_stock_name' => $stock->stock_name,
            'stock_taken_quantity' => $validated['quantity'],
            'stock_taken_price' => $stock->stock_purchase_price,
            'stock_taken_description' => $validated['description'],
            'stock_taken_category_id' => $stock->stock_category_id,
            'stock_taken_user_id' => $user->user_id
        ];

        StockTaken::create($data);

        $stock->update([
            'stock_total' => $stock->stock_total - $validated['quantity'],
            'stock_out' => $stock->stock_out + $validated['quantity']
        ]);

        $log = [
            'stock_log_stock_id' => $stock->stock_id,
            'stock_log_quantity' => $validated['quantity'],
            'stock_log_description' => 'Pengambilan Stock',
            'stock_log_status' => StockLog::OUT_STATUS,
            'stock_log_user_id' => $user->user_id,
        ];

        StockLog::create($log);

        flash()->preset('create_success');

        return redirect()->route('stock.taken');
    }

    public function report(StockTakenReportRequest $request)
    {
        $validated = $request->validated();

        $startDate = Carbon::parse($validated['start_date'])->format('d M Y');
        $endDate = Carbon::parse($validated['end_date'])->format('d M Y');

        $qStartDate = Carbon::parse($startDate)->startOfDay();
        $qEndDate = Carbon::parse($endDate)->endOfDay();

        $data = StockTaken::with(['stock', 'user', 'category'])
            ->when($validated['stock_category'] !== 'all', function ($query) use ($validated) {
                $query->where('stock_taken_category_id', $validated['stock_category']);
            })
            ->whereBetween(
                'created_at',
                [$qStartDate, $qEndDate]
            )
            ->get()
            ->groupBy('stock_taken_category_id');


        $pdf = Pdf::loadView(
            'stock.taken.report',
            compact(['data', 'startDate', 'endDate'])
        )
            ->setPaper('a4', 'landscape');

        return $pdf->download("LAPORAN-PENGAMBILAN-STOK.pdf");
    }
}
