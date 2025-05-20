<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Region;
use App\Models\Stock;
use App\Models\Supplier;
use App\Services\ValidationService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            $purchases = Purchase::with([
                'supplier',
                'region',
                'details'
            ])
                ->select([
                    'purchase_id',
                    'purchase_invoice',
                    'purchase_region_id',
                    'purchase_supplier_id',
                ]);

            return DataTables::of($purchases)
                ->addIndexColumn()
                ->escapeColumns()
                ->addColumn('actions', fn($purchase) => [
                    'detail' => route('purchase.show', $purchase->purchase_id),
                    'delete' => route('purchase.destroy', $purchase->purchase_id)
                ])
                ->toJson();
        }

        return view('purchase.index');
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
            $purchaseDetails[] = [
                'purchase_detail_purchase_id' => $purchase->purchase_id,
                'purchase_detail_stock_id' => $item['id'],
                'purchase_detail_quantity' => $item['quantity'],
                'purchase_detail_price' => $item['price'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $stock = Stock::where('stock_id', $item['id'])->first();

            if ($stock) {
                $stock->update([
                    'stock_total' => $stock->stock_total += $item['quantity'],
                    'stock_current' => $stock->stock_current += $item['quantity'],
                    'stock_in' => $stock->stock_in += $item['quantity']
                ]);
            }
        }

        $purchaseDetail = PurchaseDetail::insert($purchaseDetails);

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

    public function destroy(Purchase $purchase)
    {
        abort_unless(request()->expectsJson(), 403);
    }

    // EXTRA FUNCTION
    public function getItem(Request $request): View
    {
        $item = $request->input('item');
        $quantity = $request->input('quantity');
        $index = $request->input('index');

        $stock = Stock::where('stock_id', $item)->first();

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

    private function generateInvoice(): string
    {
        $year = now()->format('Y');
        $month = now()->format('m');
        $day = now()->format('d');

        $count = Purchase::count();

        return "INV/{$year}/{$month}/{$day}/"
            . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }
}
