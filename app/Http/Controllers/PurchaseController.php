<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseEditRequest;
use App\Http\Requests\PurchaseReportRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Region;
use App\Models\Stock;
use App\Models\StockLog;
use App\Models\Supplier;
use App\Services\ValidationService;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class PurchaseController
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

            $purchases = Purchase::with([
                'supplier',
                'region',
                'details.stock'
            ])
                ->select([
                    'purchase_id',
                    'purchase_invoice',
                    'purchase_region_id',
                    'purchase_supplier_id',
                    'created_at'
                ])
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->orderByDesc('created_at');

            $clonedPurchases = (clone $purchases)->get();

            $totalQuantity = $clonedPurchases->sum(
                fn($purchase) => $purchase->details->sum('purchase_detail_quantity')
            );

            $totalPrice = $clonedPurchases->sum(
                fn($purchase) => $purchase->details->sum('purchase_detail_total_price')
            );

            return DataTables::of($purchases)
                ->addIndexColumn()
                ->escapeColumns()
                ->addColumn('actions', fn($purchase) => [
                    'detail' => route('purchase.show', $purchase->purchase_id),
                    'delete' => route('purchase.destroy', $purchase->purchase_id),
                    'edit' => route('purchase.edit', $purchase->purchase_id)
                ])
                ->addColumn('total_items', function ($purchase) {
                    $itemCount = $purchase->details->count();
                    $totalQuantity = $purchase->details->sum('purchase_detail_quantity');
                    return "{$itemCount} barang ({$totalQuantity} pcs)";
                })
                ->addColumn('total_price', function ($purchase) {
                    return $purchase->details->sum('purchase_detail_total_price');
                })
                ->with([
                    'total_price' => $totalPrice,
                    'total_quantity' => $totalQuantity
                ])
                ->toJson();
        }

        $categories = Category::getItemCategories()->prepend('Semua Kategori', 'all');

        $validator = $this->validationService
            ->generateValidation(PurchaseReportRequest::class, '#form-report');

        return view('purchase.index', compact(['categories', 'validator']));
    }

    public function create(): View
    {
        $validator = $this->validationService
            ->generateValidation(PurchaseRequest::class, '#form-create-purchase');

        $regions = Region::getRegionDropdown();

        $suppliers = Supplier::getSupplierDropdown();

        $stocks = Stock::getStockDropdown();

        $invoice = $this->generateInvoice();

        return view('purchase.create', compact(
            ['validator', 'regions', 'suppliers', 'stocks', 'invoice']
        ));
    }

    public function store(PurchaseRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->safe()->except('purchase_items');
        $items = $request->input('purchase_items');
        $merged = [];

        foreach ($items as $item) {
            $code = $item['code'];

            if (!isset($merged[$code])) {
                $merged[$code] = $item;
            } else {
                $merged[$code]['quantity'] += $item['quantity'];
            }
        }

        $mergeItems = array_values($merged);

        DB::beginTransaction();

        $purchase = Purchase::create($validated);

        if (!$purchase) {
            DB::rollBack();
            flash()->preset('create_error');
            return redirect()->back();
        }

        foreach ($mergeItems as $item) {
            $stock = Stock::with('category')
                ->where('stock_id', $item['id'])->first();

            $purchaseDetails[] = [
                'purchase_detail_purchase_id' => $purchase->purchase_id,
                'purchase_detail_stock_id' => $item['id'],
                'purchase_detail_stock_code' => $stock->stock_code,
                'purchase_detail_stock_name' => $stock->stock_name,
                'purchase_detail_stock_category_id' => $stock->stock_category_id,
                'purchase_detail_stock_category_name' => $stock->category->category_name,
                'purchase_detail_stock_unit' => $stock->stock_unit,
                'purchase_detail_cost_price' => $stock->stock_purchase_price,
                'purchase_detail_price' => $item['price'],
                'purchase_detail_quantity' => $item['quantity'],
                'purchase_detail_total_price' => $item['price'] * $item['quantity'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $stockLogs[] = [
                'stock_log_stock_id' => $item['id'],
                'stock_log_quantity' => $item['quantity'],
                'stock_log_description' => 'Perubahan jumlah stok dari pembelian',
                'stock_log_status' => StockLog::IN_STATUS,
                'stock_log_user_id' => $user->user_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            if ($stock) {
                $stock->update([
                    'stock_total' => $stock->stock_total += $item['quantity'],
                    'stock_in' => $stock->stock_in += $item['quantity']
                ]);
            }
        }

        $purchaseDetail = PurchaseDetail::insert($purchaseDetails);

        StockLog::insert($stockLogs);

        if (!$purchaseDetail) {
            DB::rollBack();
            flash()->preset('create_error');
            return redirect()->route('purchase.index');
        }

        DB::commit();
        flash()->preset('create_success');
        return redirect()->route('purchase.index');
    }

    public function show(Purchase $purchase): View
    {
        $purchase->load([
            'supplier.region',
            'region',
            'details.stock'
        ]);

        return view('purchase.detail', compact('purchase'));
    }

    public function edit(Purchase $purchase): View
    {
        $validator = $this->validationService
            ->generateValidation(PurchaseEditRequest::class, '#form-edit-purchase');

        $regions = Region::getRegionDropdown();

        $suppliers = Supplier::getSupplierDropdown();

        $stocks = Stock::getStockDropdown();

        $details = $purchase->details;

        $state = "edit";

        $purchaseDetailsHtml = '';
        $index = 0;

        foreach($details as $detail) {
            $purchaseDetailsHtml .= view('purchase._data-edit')->with([
                'data' => [
                    'id' => $detail->stock->stock_id,
                    'code' => $detail->stock->stock_code,
                    'name' => $detail->stock->stock_name,
                    'price' => $detail->stock->stock_purchase_price,
                    'quantity' => $detail->purchase_detail_quantity,
                    'total' => $detail->purchase_detail_quantity * $detail->stock->stock_purchase_price,
                    'purchase_id' => $detail->purchase_detail_id
                ],
                'index' => $index
            ])->render();

            $index++;
        }

        return view('purchase.edit', compact([
            'purchase', 'regions', 'suppliers', 'stocks', 'validator', 'purchaseDetailsHtml', 'state'
        ]));
    }

    public function update(PurchaseEditRequest $request, Purchase $purchase): RedirectResponse
    {
        $validated = $request->validated();

        $purchase->update($validated);

        flash()->preset('update_success');
        return redirect()->route('purchase.index');
    }

    public function destroy(Purchase $purchase): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        $details = $purchase->details;

        foreach ($details as $detail) {
            $stock = Stock::firstWhere('stock_id', $detail->purchase_detail_stock_id);

            if ($stock) {
                $stockTotal = (int) $stock->stock_total;
                $stockIn = (int) $stock->stock_in;
                $qty = (int) $detail->purchase_detail_quantity;

                $stock->stock_total = $stockTotal - $qty;
                $stock->stock_in = $stockIn - $qty;
                $stock->save();
            }

            $detail->delete();
        }

        $purchase->delete();

        return response()->json([
            'success' => true,
            'message' => 'Purchase berhasil dihapus'
        ]);
    }

    // public function report(PurchaseReportRequest $request)
    // {
    //     $validated = $request->validated();

    //     $category = $validated['stock_category'];
    //     $startDate = $validated['start_date'];
    //     $endDate = $validated['end_date'];

    //     $startDate = Carbon::parse($startDate)->startOfDay();
    //     $endDate = Carbon::parse($endDate)->endOfDay();

    //     $purchases = Purchase::whereBetween('created_at', [$startDate, $endDate])
    //         ->whereHas('details', function ($query) use ($category) {
    //             if ($category !== 'all') {
    //                 $query->where('purchase_detail_stock_category_id', $category);
    //             }
    //         })
    //         ->with([
    //             'details' => function ($query) use ($category) {
    //                 if ($category !== 'all') {
    //                     $query->where('purchase_detail_stock_category_id', $category);
    //                 }
    //             },
    //             'supplier',
    //             'region'
    //         ])
    //         ->get();

    //     $datas = $purchases->map(fn($purchase) => [
    //         'invoice' => $purchase->purchase_invoice,
    //         'description' => $purchase->purchase_description,
    //         'date' => $purchase->created_at,
    //         'supplier' => $purchase->supplier->supplier_code . " - " . $purchase->supplier->supplier_name,
    //         'region' => $purchase->region->region_code . " - " . $purchase->region->region_name,
    //         'items' => $purchase->details->map(function ($detail) {
    //             return [
    //                 'code' => $detail->purchase_detail_stock_code,
    //                 'name' => $detail->purchase_detail_stock_name,
    //                 'category' => $detail->purchase_detail_stock_category_name,
    //                 'price' => $detail->purchase_detail_price,
    //                 'quantity' => $detail->purchase_detail_quantity,
    //                 'subtotal' => $detail->purchase_detail_total_price
    //             ];
    //         })
    //     ]);

    //     $totals = [
    //         'total_quantity' => 0,
    //         'total_price' => 0,
    //     ];

    //     foreach ($datas as $purchase) {
    //         foreach ($purchase['items'] as $detail) {
    //             $totals['total_quantity'] += $detail['quantity'];
    //             $totals['total_price'] += $detail['subtotal'];
    //         }
    //     }

    //     $startDate = Carbon::parse($startDate)->format('d M Y');
    //     $endDate = Carbon::parse($endDate)->format('d M Y');

    //     $pdf = Pdf::loadView(
    //         'purchase.report',
    //         compact(['datas', 'totals', 'startDate', 'endDate'])
    //     )
    //         ->setPaper('a4', 'landscape');

    //     return $pdf->download("LAPORAN-PENJUALAN-DETAIL-{$startDate}-{$endDate}.pdf");
    // }

    public function report(PurchaseReportRequest $request)
    {
        $validated = $request->validated();

        $category = $validated['stock_category'];

        $startDate = Carbon::parse($validated['start_date'])->startOfDay();
        $endDate   = Carbon::parse($validated['end_date'])->endOfDay();

        $purchases = Purchase::select([
                'purchase_id',
                'purchase_invoice',
                'purchase_description',
                'supplier_id',
                'region_id',
                'created_at'
            ])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with([
                'supplier:id,supplier_code,supplier_name',
                'region:id,region_code,region_name',
                'details' => function ($query) use ($category) {
                    $query->select([
                        'purchase_id',
                        'purchase_detail_stock_code',
                        'purchase_detail_stock_name',
                        'purchase_detail_stock_category_name',
                        'purchase_detail_price',
                        'purchase_detail_quantity',
                        'purchase_detail_total_price',
                        'purchase_detail_stock_category_id',
                    ]);

                    if ($category !== 'all') {
                        $query->where('purchase_detail_stock_category_id', $category);
                    }
                }
            ])
            ->whereHas('details', function ($query) use ($category) {
                if ($category !== 'all') {
                    $query->where('purchase_detail_stock_category_id', $category);
                }
            })
            ->get();

        $datas = $purchases->map(function ($purchase) {
            return [
                'invoice' => $purchase->purchase_invoice,
                'description' => $purchase->purchase_description,
                'date' => $purchase->created_at->format('d M Y'),
                'supplier' => $purchase->supplier
                    ? $purchase->supplier->supplier_code . ' - ' . $purchase->supplier->supplier_name
                    : '-',
                'region' => $purchase->region
                    ? $purchase->region->region_code . ' - ' . $purchase->region->region_name
                    : '-',
                'items' => $purchase->details->map(function ($detail) {
                    return [
                        'code' => $detail->purchase_detail_stock_code,
                        'name' => $detail->purchase_detail_stock_name,
                        'category' => $detail->purchase_detail_stock_category_name,
                        'price' => $detail->purchase_detail_price,
                        'quantity' => $detail->purchase_detail_quantity,
                        'subtotal' => $detail->purchase_detail_total_price
                    ];
                })
            ];
        });

        $totals = [
            'total_quantity' => 0,
            'total_price' => 0,
        ];

        foreach ($datas as $purchase) {
            foreach ($purchase['items'] as $detail) {
                $totals['total_quantity'] += $detail['quantity'];
                $totals['total_price'] += $detail['subtotal'];
            }
        }

        $startDateFormatted = $startDate->format('d M Y');
        $endDateFormatted   = $endDate->format('d M Y');

        $pdf = SnappyPdf::loadView('purchase.report', [
                'datas' => $datas,
                'totals' => $totals,
                'startDate' => $startDateFormatted,
                'endDate' => $endDateFormatted,
            ])
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('no-outline', true)
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10)
            ->setOption('margin-right', 10);

        return $pdf->download("LAPORAN-PENJUALAN-DETAIL-{$startDateFormatted}-{$endDateFormatted}.pdf");
    }

    // EXTRA FUNCTION
    public function getItem(Request $request): View|JsonResponse
    {
        $item = $request->input('item');
        $quantity = $request->input('quantity');
        $index = $request->input('index');

        $stock = Stock::where('stock_code', $item)->first();

        if (!$stock) {
            return response()->json(false);
        }

        $data = [
            'id' => $stock->stock_id,
            'code' => $stock->stock_code,
            'name' => $stock->stock_name,
            'price' => $stock->stock_purchase_price,
            'quantity' => $quantity,
            'total' => $quantity * $stock->stock_purchase_price
        ];

        return view('purchase._data', compact(['data', 'index']));
    }

    public function searchItem(Request $request): JsonResponse
    {
        $keyword = $request->q;
        
        $items = Stock::where('stock_name', 'like', "%{$keyword}%")
            ->orWhere('stock_code', 'like', "%{$keyword}%")
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }

    private function generateInvoice(): string
    {
        $year = now()->format('Y');
        $month = now()->format('m');
        $day = now()->format('d');

        $count = Purchase::count();

        return "INV/{$year}/{$month}/{$day}/"
            . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }

    public function updateItem(Request $request): JsonResponse
    {
        $stock = Stock::firstWhere('stock_id', $request->stockId);
        $item = PurchaseDetail::firstWhere('purchase_detail_id', $request->id);

        $oldQty = $item->purchase_detail_quantity;
        $newQty = $request->quantity;

        $stock->stock_total -= $oldQty;
        $stock->stock_in -= $oldQty;
        $stock->stock_total += $newQty;
        $stock->stock_in += $newQty;
        $stock->save();

        $item->purchase_detail_quantity = $request->quantity;
        $item->purchase_detail_total_price = $request->quantity * $item->purchase_detail_price;
        $item->save();

        return response()->json([
            'total' => $item->purchase_detail_total_price,
            'total_rp' => number_format($item->purchase_detail_total_price, 0, ',', '.')
        ]);
    }

    public function deleteItem(Request $request): JsonResponse
    {
        $item = PurchaseDetail::firstWhere('purchase_detail_id', $request->id);
        $stock = Stock::firstWhere('stock_id', $request->stockId);

        $stockTotal = (int) $stock->stock_total;
        $stockIn = (int) $stock->stock_in;
        $qty = (int) $item->purchase_detail_quantity;

        $stock->stock_total = $stockTotal - $qty;
        $stock->stock_in = $stockIn - $qty;

        $stock->save();
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus'
        ]);
    }
}
