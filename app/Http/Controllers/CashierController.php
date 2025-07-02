<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Customer;
use App\Models\CustomerCredit;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CashierController
{
    public function index(): View
    {
        // $customers = Customer::getCustomerDropdown();
        // $stocks = Stock::getConcatedStockDropdown();

        // return view('cashier.index', compact(['customers', 'stocks']));

        $store = Store::first();

        return view('cashier.v2.index', compact('store'));
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

    public function getCredit(Request $request): View
    {
        $customerId = $request->input('customerId');

        $customer = Customer::with([
            'credits' => function ($query) {
                $query->where('customer_credit_status', CustomerCredit::UNPAID_STATUS);
            }
        ])
            ->where('customer_id', $customerId)
            ->first();

        return view('cashier._credit', compact('customer'));
    }

    public function checkout(CheckoutRequest $request): JsonResponse
    {
        $validated = $request->validated();

        DB::beginTransaction();

        // GET THE STOCK
        $stockIds = collect($validated['items'])->pluck('stockId');
        $stocks = Stock::with('category')->whereIn('stock_id', $stockIds)->get()->keyBy('stock_id');

        // SAVE TO SALES
        $invoice = $this->generateInvoice();
        $totalPrice = collect($validated['items'])->sum(function ($item) {
            return intval($item['price']) * intval($item['quantity']);
        });
        $totalDiscount = ($totalPrice * $validated['discount']) / 100;
        $totalPriceAfterDiscount = $totalPrice - $totalDiscount;
        $totalChange = $validated['total_payment'] - $totalPriceAfterDiscount;

        $salesData = [
            'sales_invoice' => $invoice,
            'sales_customer_id' => $validated['customer_id'],
            'sales_payment_type' => $validated['payment_type'],
            'sales_total_price' => $totalPrice,
            'sales_total_payment' => $validated['total_payment'],
            'sales_total_change' => $totalChange,
            'sales_discount' => $validated['discount'],
            'sales_total_discount' => $totalDiscount,
            'sales_total_price_after_discount' => $totalPriceAfterDiscount,
            'sales_status' => $validated['is_credit'] ? Sale::CREDIT_STATUS : Sale::PAID_STATUS
        ];

        // IF CUSTOMER WANT TO CREDIT (HUTANG)
        $creditAmount = 0;

        if ($validated['is_credit'] && $validated['customer_id'] !== 1) {
            $creditAmount = $totalPriceAfterDiscount - $validated['total_payment'];

            if ($creditAmount < 0) {
                $creditAmount = 0;
            }

            $salesData['sales_customer_total_credit'] = $creditAmount;
        }

        $salesResult = Sale::create($salesData);

        if (!$salesResult) {
            DB::rollBack();
            return response()->json([
                'result' => false,
                'message' => "Pembelian gagal dilakukan 1."
            ]);
        }

        // INSERT TO TABLE CUSTOMER CREDIT
        if ($creditAmount > 0 && $validated['is_credit']) {
            $creditData = [
                'customer_credit_sales_id' => $salesResult->sales_id,
                'customer_credit_customer_id' => $validated['customer_id'],
                'customer_credit_invoice' => $invoice,
                'customer_credit_total_purchase' => $totalPriceAfterDiscount,
                'customer_credit_total_payment' => $validated['total_payment'],
                'customer_credit' => $creditAmount,
                'customer_credit_status' => CustomerCredit::UNPAID_STATUS
            ];

            $customerCredit = CustomerCredit::create($creditData);

            if (!$customerCredit) {
                DB::rollBack();
                return response()->json([
                    'result' => false,
                    'message' => "Pembelian gagal dilakukan 2."
                ]);
            }
        }

        // SAVE TO SALE DETAILS
        $salesId = $salesResult->sales_id;
        $saleDetails = [];

        foreach ($validated['items'] as $item) {
            $stockData = $stocks[$item['stockId']];

            $saleDetails[] = [
                'sale_detail_sales_id' => $salesId,
                'sale_detail_stock_id' => $stockData->stock_id,
                'sale_detail_stock_code' => $stockData->stock_code,
                'sale_detail_stock_name' => $stockData->stock_name,
                'sale_detail_stock_category_id' => $stockData->stock_category_id,
                'sale_detail_stock_category_name' => $stockData->category->category_name,
                'sale_detail_stock_unit' => $stockData->stock_unit,
                'sale_detail_cost_price' => $stockData->stock_purchase_price,
                'sale_detail_price' => $item['price'],
                'sale_detail_quantity' => $item['quantity'],
                'sale_detail_total_price' => $item['quantity'] * $item['price'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $saleDetailsResult = SaleDetail::insert($saleDetails);

        if (!$saleDetailsResult) {
            DB::rollBack();
            return response()->json([
                'result' => false,
                'message' => "Pembelian gagal dilakukan 3."
            ]);
        }

        // UPDATE STOCK
        foreach ($validated['items'] as $item) {
            $stock = $stocks[$item['stockId']];
            $stock->stock_current -= $item['quantity'];
            $stock->stock_out += $item['quantity'];
            $stock->save();
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'id' => $salesId,
            'message' => "Pembelian berhasil. Nomor invoice $invoice"
        ]);
    }

    private function generateInvoice(): string
    {
        $year = now()->format('Y');
        $month = now()->format('m');
        $day = now()->format('d');

        $count = Sale::count();

        return "INV/ORD/{$year}/{$month}/{$day}/"
            . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }
}
