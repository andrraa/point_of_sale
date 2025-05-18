<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Models\Region;
use App\Models\Stock;
use App\Models\Supplier;
use App\Services\ValidationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseController
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index(): View
    {
        return view('purchase.index');
    }

    public function create(): View
    {
        $validator = $this->validationService->generateValidation(PurchaseRequest::class, '#form-create-purchase');

        $regions = Region::getRegionDropdown();

        $suppliers = Supplier::getSupplierDropdown();

        $stocks = Stock::getStockDropdown();

        return view('purchase.create', compact(['validator', 'regions', 'suppliers', 'stocks']));
    }

    public function store(PurchaseRequest $request)
    {

    }

    public function edit(Purchase $purchase): View
    {
        $validator = $this->validationService->generateValidation(PurchaseRequest::class, '#form-edit-purchase');

        $regions = Region::getRegionDropdown();

        $suppliers = Supplier::getSupplierDropdown();

        return view('purchase.edit', compact(['purchase', 'validator', 'regions', 'suppliers']));
    }

    public function update(PurchaseRequest $request, Purchase $purchase)
    {

    }

    public function destroy()
    {

    }

    // EXTRA FUNCTION
    public function getItem(Request $request): View
    {
        $item = $request->input('item');
        $quantity = $request->input('quantity');

        $stock = Stock::where('stock_id', $item)->first();

        $data = [
            'code' => $stock->stock_code,
            'name' => $stock->stock_name,
            'price' => $stock->stock_purchase_price,
            'quantity' => $quantity,
            'total' => $quantity * $stock->stock_purchase_price
        ];

        return view('purchase._data', compact('data'));
    }
}
