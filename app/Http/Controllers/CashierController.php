<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CashierController
{
    public function index(): View
    {
        $customers = Customer::getCustomerDropdown();
        $stocks = Stock::getConcatedStockDropdown();

        return view('cashier.index', compact(['customers', 'stocks']));
    }

    public function getItem(Request $request): JsonResponse
    {
        $customerId = $request->input('customerId');
        $stockId = $request->input('stockId');
        $quantity = $request->input('quantity');

        $stock = Stock::where('stock_id', $stockId)->first();

        if ($stock->stock_current < $quantity) {
            return response()->json([
                'success' => false,
                'message' => "Stock tidak mencukupi untuk barang $stock->stock_name"
            ]);
        }

        $customer = Customer::where('customer_id', $customerId)->first();

        $data = [
            'stockId' => $stock->stock_id,
            'stockName' => $stock->stock_name,
            'quantity' => $quantity,
            'maxQuantity' => $stock->stock_current
        ];

        $data['price'] = match ($customer->customer_category_id) {
            Customer::CUSTOMER_GENERAL_PRICE => $stock->stock_sale_price_1,
            Customer::CUSTOMER_GROCIER_PRICE => $stock->stock_sale_price_2,
            Customer::CUSTOMER_WAREHOUSE_PRICE => $stock->stock_sale_price_3,
            default => $stock->stock_sale_price_1,
        };

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getCredit(Request $request)
    {
        $customerId = $request->input('customerId');

        $customer = Customer::where('customer_id', $customerId)->first();
    }
}
