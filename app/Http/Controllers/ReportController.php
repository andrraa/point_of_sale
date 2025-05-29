<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportPurchaseRequest;
use App\Http\Requests\ReportSalesRequest;
use App\Models\Category;
use App\Models\Purchase;
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

        if ($validated['sale_type'] === 'detail') {
            $startDate = Carbon::parse($validated['sale_start_date'])->startOfDay();
            $endDate = Carbon::parse($validated['sale_end_date'])->endOfDay();

            $reports = Sale::with(['details', 'customer.category'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $reportData = [];

            foreach ($reports as $report) {
                $stocks = [];
                $totalStockPrice = 0;
                $totalHppPrice = 0;

                foreach ($report->details as $detail) {
                    $total = $detail->sale_detail_quantity * $detail->sale_detail_price;
                    $totalHpp = $detail->sale_detail_quantity * $detail->sale_detail_cost_price;

                    $totalStockPrice += $total;
                    $totalHppPrice += $totalHpp;

                    $stocks[] = [
                        'stockCode' => $detail->sale_detail_stock_code,
                        'stockName' => $detail->sale_detail_stock_name,
                        'quantity' => $detail->sale_detail_quantity,
                        'price' => $detail->sale_detail_price,
                        'total' => $total,
                        'hppPrice' => $totalHpp,
                        'lr' => $total - $totalHpp,
                    ];
                }

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
                        'customerCategory' => $report->customer->category->category_name,
                    ],
                    'stocks' => $stocks,
                ];
            }

            $formattedStartDate = $startDate->format('d-M-Y');
            $formattedEndDate = $endDate->format('d-M-Y');

            $pdf = Pdf::loadView('report._sales-detail', compact('formattedStartDate', 'formattedEndDate', 'reportData'))
                ->setPaper('a4', 'landscape');

            return $pdf->download("LAPORAN-PENJUALAN-{$formattedStartDate}-sd-{$formattedEndDate}.pdf");
        }

        if ($validated['sales_type'] == 'analyse') {

        }

        flash()->error('Terdapat kesalahan. Silahkan coba lagi');

        return redirect()->route('report');
    }

    public function purchase(ReportPurchaseRequest $request)
    {
        $validated = $request->validated();

        if ($validated['purchase_type'] == 'detail') {
            $startDate = Carbon::parse($validated['purchase_start_date'])->startOfDay();
            $endDate = Carbon::parse($validated['purchase_end_date'])->endOfDay();

            $purchases = Purchase::with(['details', 'supplier'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $reportData = [];

            foreach ($purchases as $purchase) {
                $subtotal = 0;
                $stocks = [];

                foreach ($purchase->details as $detail) {
                    $total = $detail->purchase_detail_quantity * $detail->purchase_detail_price;

                    $stocks[] = [
                        'stockCode' => $detail->purchase_detail_stock_code,
                        'stockName' => $detail->purchase_detail_stock_name,
                        'quantity' => $detail->purchase_detail_quantity,
                        'price' => $detail->purchase_detail_price,
                        'total' => $total,
                    ];
                }

                $reportData[] = [
                    'invoice' => $purchase->purchase_invoice,
                    'date' => $purchase->created_at,
                    'subtotalPrice' => $purchase->purchase_detail_total_price,
                    'supplier' => [
                        'supplierName' => $purchase->supplier->supplier_name,
                    ],
                    'stocks' => $stocks
                ];
            }

            return view('report._purchase-detail', compact('reportData'));
        }
    }
}
