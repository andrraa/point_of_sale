<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleReportRequest;
use App\Models\Category;
use App\Models\Sale;
use App\Services\ValidationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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

            $totalPrice = (clone $sales)->sum('sales_total_price');
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
                        // $actions['detail'] = route('sale.show', $sale->sales_id);
                    }

                    return $actions;
                })
                ->addColumn('created_at', fn($sale) => $sale->formatted_created_at)
                ->with([
                    'total_price' => $totalPrice,
                    'total_debt' => $totalDebt
                ])
                ->toJson();
        }

        $categories = Category::getItemCategories();

        $validator = $this->validationService
            ->generateValidation(SaleReportRequest::class, '#form-report');

        return view('sale.index', compact(['categories', 'validator']));
    }

    public function edit(Sale $sale): View
    {
        $sale->load(['details']);

        return view('sale.edit', compact('sale'));
    }

    public function show(Sale $sale): View
    {
        $store = Session::get('store');

        $sale->load(['details', 'customer']);

        return view('sale._print', compact(['sale', 'store']));
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

        $startDate = $validated['start_date'];
        $endDate = $validated['end_date'];
        $typeCategory = $validated['type_category'];
        $stockCategory = $validated['stock_category'];

        return $typeCategory === '1'
            ? $this->reportDetail($startDate, $endDate, $stockCategory)
            : $this->reportGeneral($startDate, $endDate, $stockCategory);
    }

    private function reportDetail($startDate, $endDate, $categoryId)
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $sales = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->where(function ($query) {
                $query->where('sales_status', SALE::PAID_STATUS)
                    ->orWhere('sales_status', SALE::CREDIT_STATUS);
            })
            ->whereNull('deleted_at')
            ->whereHas('details', function ($query) use ($categoryId) {
                if ($categoryId !== 'all') {
                    $query->where('sale_detail_stock_category_id', $categoryId);
                }
            })
            ->with([
                'details' => function ($query) use ($categoryId) {
                    if ($categoryId !== 'all') {
                        $query->where('sale_detail_stock_category_id', $categoryId);
                    }
                }
            ])
            ->get();

        $datas = $sales->map(
            fn($sale) => [
                'invoice' => $sale->sales_invoice,
                'total_gross' => $sale->sales_total_gross,
                'total_price' => $sale->sales_total_price,
                'total_debt' => $sale->sale_total_debt ?? 0,
                'total_change' => $sale->sales_total_change,
                'date' => $sale->created_at,
                'items' => $sale->details->map(function ($detail) {
                    $profit = ($detail->sale_detail_price - $detail->sale_detail_cost_price)
                        * $detail->sale_detail_quantity;

                    return [
                        'code' => $detail->sale_detail_stock_code,
                        'name' => $detail->sale_detail_stock_name,
                        'quantity' => $detail->sale_detail_quantity,
                        'category' => $detail->sale_detail_stock_category_name,
                        'cost_price' => $detail->sale_detail_cost_price,
                        'sell_price' => $detail->sale_detail_price,
                        'total_price' => $detail->sale_detail_total_price,
                        'discount' => $detail->sale_detail_discount,
                        'discount_amount' => $detail->sale_detail_discount_amount,
                        'profit' => $profit
                    ];
                }),
            ]
        );

        $totals = [
            'total_quantity' => 0,
            'total_sell_price' => 0,
            'total_debt' => 0,
            'total_discount_amount' => 0,
            'total_profit' => 0,
        ];

        foreach ($datas as $sale) {
            $totals['total_debt'] += $sale['total_debt'];

            foreach ($sale['items'] as $item) {
                $totals['total_quantity'] += $item['quantity'];
                $totals['total_sell_price'] += $item['sell_price'];
                $totals['total_discount_amount'] += $item['discount_amount'];
                $totals['total_profit'] += $item['profit'];
            }
        }

        $formattedStartDate = Carbon::parse($startDate)->format('d M Y');
        $formattedEndDate = Carbon::parse($endDate)->format('d M Y');

        $pdf = Pdf::loadView(
            'sale.report.detail',
            compact(['datas', 'totals', 'formattedStartDate', 'formattedEndDate'])
        )
            ->setPaper('a4', 'landscape');

        return $pdf->download("LAPORAN-PENJUALAN-DETAIL-{$startDate}-{$endDate}.pdf");
    }

    private function reportGeneral($startDate, $endDate, $categoryId)
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $sales = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->where('sales_status', SALE::PAID_STATUS)
            ->whereNull('deleted_at')
            ->whereHas('details', function ($query) use ($categoryId) {
                if ($categoryId !== 'all') {
                    $query->where('sale_detail_stock_category_id', $categoryId);
                }
            })
            ->with([
                'details' => function ($query) use ($categoryId) {
                    if ($categoryId !== 'all') {
                        $query->where('sale_detail_stock_category_id', $categoryId);
                    }
                }
            ])
            ->get();

        $categoryName = null;

        if ($categoryId !== 'all') {
            $category = Category::find($categoryId);
            $categoryName = $category?->category_name ?? 'Kategori Tidak Ditemukan';
        }

        $monthlyData = [];

        foreach ($sales as $sale) {
            $monthKey = $sale->created_at->format('Y-m');

            if (!isset($monthlyData[$monthKey])) {
                $monthlyData[$monthKey] = [
                    'month' => Carbon::parse($sale->created_at)->translatedFormat('F Y'),
                    'total_quantity' => 0,
                    'total_sell_price' => 0,
                    'total_discount_amount' => 0,
                    'total_profit' => 0,
                    'total_debt' => 0,
                ];
            }

            $monthlyData[$monthKey]['total_debt'] += $sale->sale_total_debt ?? 0;

            foreach ($sale->details as $detail) {
                $monthlyData[$monthKey]['total_quantity'] += $detail->sale_detail_quantity;
                $monthlyData[$monthKey]['total_sell_price'] += $detail->sale_detail_price;
                $monthlyData[$monthKey]['total_discount_amount'] += $detail->sale_detail_discount_amount;
                $monthlyData[$monthKey]['total_profit'] += ($detail->sale_detail_price - $detail->sale_detail_cost_price) * $detail->sale_detail_quantity;
            }
        }

        $formattedStartDate = Carbon::parse($startDate)->format('d M Y');
        $formattedEndDate = Carbon::parse($endDate)->format('d M Y');

        $pdf = Pdf::loadView(
            'sale.report.general',
            compact([
                'monthlyData',
                'formattedStartDate',
                'formattedEndDate',
                'categoryName'
            ])
        )
            ->setPaper('a4', 'landscape');

        return $pdf->download("LAPORAN-PENJUALAN-UMUM-{$startDate}-{$endDate}.pdf");
    }
}
