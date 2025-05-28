<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportPurchaseRequest;
use App\Http\Requests\ReportSalesRequest;
use App\Models\Category;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\View\View;

class ReportController
{
    public function index(): View
    {
        $today = Carbon::today()->toDateString();
        $categories = Category::getItemCategories();
        $categories = collect([0 => 'Semua'])->union($categories);

        return view('report.index', compact(['categories', 'today']));
    }

    public function sales(ReportSalesRequest $request)
    {
        $validated = $request->validated();

        if ($validated['sale_type'] == 'detail') {
            $startDate = Carbon::parse($validated['sale_start_date'])->startOfDay();
            $endDate = Carbon::parse($validated['sale_end_date'])->endOfDay();
            $categoryId = (int) $validated['sale_category'];

            $reports = Sale::with([
                'details' => function ($q) use ($categoryId) {
                    if ($categoryId !== 0) {
                        $q->where('sale_detail_stock_category_id', $categoryId);
                    }
                },
                'customer.category'
            ])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->when($categoryId !== 0, function ($query) use ($categoryId) {
                    $query->whereHas('details', function ($q) use ($categoryId) {
                        $q->where('sale_detail_stock_category_id', $categoryId);
                    });
                }, function ($query) {
                    $query->whereHas('details');
                })
                ->get();

            $reportData = [];

            foreach ($reports as $report) {
                $discount = 0;
                $subtotal = 0;
                $stocks = [];

                $totalStockPrice = 0;
                $totalHppPrice = 0;

                foreach ($report->details as $index => $detail) {
                    $total = $detail->sale_detail_quantity * $detail->sale_detail_price;
                    $totalHpp = $detail->sale_detail_cost_price * $detail->sale_detail_quantity;
                    $totalStockPrice += $total;
                    $totalHppPrice += $totalHpp;

                    $stocks[] = [
                        'stockCode' => $detail->sale_detail_stock_code,
                        'stockName' => $detail->sale_detail_stock_name,
                        'quantity' => $detail->sale_detail_quantity,
                        'price' => $detail->sale_detail_price,
                        'total' => $total,
                        'hppPrice' => $totalHpp,
                        'lr' => $total - $totalHpp
                    ];
                }

                $totalLR = $totalStockPrice - $totalHppPrice;

                $reportData[] = [
                    'invoice' => $report->sales_invoice,
                    'date' => $report->created_at,
                    'subtotalPrice' => $report->sales_total_price,
                    'subtotalDiscount' => $report->sales_total_discount,
                    'subtotalStockPrice' => $totalStockPrice,
                    'subtotalHppPrice' => $totalHppPrice,
                    'subtotalCredit' => $report->sales_customer_total_credit,
                    'customer' => [
                        'customerName' => $report->customer->customer_name,
                        'customerCategory' => $report->customer->category->category_name
                    ],
                    'stocks' => $stocks
                ];
            }

            // return view('report._sales-detail', compact(['reportData', 'formattedStartDate', 'formattedEndDate']));
            $formattedStartDate = $startDate->format('d-M-Y');
            $formattedEndDate = $startDate->format('d-M-Y');

            $pdf = Pdf::loadView(
                'report._sales-detail',
                compact(['formattedStartDate', 'formattedEndDate', 'reportData'])
            )
                ->setPaper('a4', 'landscape');

            return $pdf
                ->download("LAPORAN-PENJUALAN-{$formattedStartDate}-sd-{$formattedEndDate}.pdf");
        }

        if ($validated['sales_type'] == 'analyse') {

        }

        flash()->error('Terdapat kesalahan. Silahkan coba lagi');

        return redirect()->route('report');
    }

    public function purchase(ReportPurchaseRequest $request)
    {
        $validated = $request->validated();
    }
}
