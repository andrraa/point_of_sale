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
        $store = Store::first();
        $customers = Customer::getCustomerDropdown();

        return view('cashier.v2.index', compact(['store', 'customers']));
    }

    public function getItem(Request $request): JsonResponse
    {
        $customerId = $request->input('customer');
        $stockCode = $request->input('code');

        $stock = Stock::firstWhere('stock_code', $stockCode);
        $customer = Customer::with('category')->where('customer_id', $customerId)->first();

        if (!$stock) {
            return response()->json([
                'success' => false,
                'message' => "Stock tidak ditemukan"
            ]);
        }

        $data = [
            'id' => $stock->stock_id,
            'code' => $stock->stock_code,
            'name' => $stock->stock_name,
            'quantity' => 1,
            'discount' => 0,
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

    public function getCredit(Request $request): JsonResponse
    {
        $customerId = $request->input('customerId');

        $customer = Customer::with([
            'credits' => function ($query) {
                $query->where('customer_credit_status', CustomerCredit::UNPAID_STATUS);
            }
        ])
            ->where('customer_id', $customerId)
            ->first();

        $totalDebt = 0;
        if ($customer && $customer->credits) {
            $totalDebt = $customer->credits->sum('customer_credit');
        }

        return response()->json([
            'debt' => $totalDebt
        ]);
    }

    public function checkout(CheckoutRequest $request): JsonResponse
    {
        $validated = $request->validated();

        DB::beginTransaction();

        // GET THE STOCK
        $stockIds = collect($validated['items'])->pluck('id');
        $stocks = Stock::with('category')
            ->whereIn('stock_id', $stockIds)
            ->get()
            ->keyBy('stock_id');

        // SAVE TO SALES
        $invoice = $this->generateInvoice();

        $totalGross = 0;
        $totalPrice = collect($validated['items'])->sum(function ($item) use (&$totalGross) {
            $price = floatval($item['price']);
            $quantity = intval($item['quantity']);
            $discount = intval($item['discount']);

            $subtotal = $price * $quantity;
            $discountAmount = $subtotal * ($discount / 100);

            $totalGross += $subtotal;

            return $subtotal - $discountAmount;
        });


        $totalChange = 0;
        $totalDebt = 0;

        if ($validated['customerPay'] >= $totalPrice) {
            $totalChange = $validated['customerPay'] - $totalPrice;
        } else if ($validated['customerPay'] < $totalPrice) {
            $totalDebt = $totalPrice - $validated['customerPay'];
        }

        $paymentType = $totalDebt > 0 ? 'credit' : 'cash';

        $salesData = [
            'sales_invoice' => $invoice,
            'sales_customer_id' => $validated['customerId'],
            'sales_payment_type' => $paymentType,
            'sales_total_price' => $totalPrice,
            'sales_total_gross' => $totalGross,
            'sales_total_payment' => $validated['customerPay'],
            'sales_total_change' => $totalChange,
            'sales_status' => $totalDebt > 0 ? Sale::CREDIT_STATUS : sale::PAID_STATUS
        ];

        $salesResult = Sale::create($salesData);

        if (!$salesResult) {
            DB::rollBack();
            return response()->json([
                'result' => false,
                'message' => "Pembelian gagal dilakukan 1."
            ]);
        }

        // INSERT TO TABLE CUSTOMER CREDIT
        if ($totalDebt > 0) {
            $creditData = [
                'customer_credit_sales_id' => $salesResult->sales_id,
                'customer_credit_customer_id' => $validated['customerId'],
                'customer_credit_invoice' => $invoice,
                'customer_credit_total_purchase' => $totalPrice,
                'customer_credit_total_payment' => $validated['customerPay'],
                'customer_credit' => $totalDebt,
                'customer_credit_status' => CustomerCredit::UNPAID_STATUS,
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
            $stockData = $stocks[$item['id']];

            $saleDetails[] = [
                'sale_detail_sales_id' => $salesId,
                'sale_detail_stock_id' => $stockData->stock_id,
                'sale_detail_stock_code' => $stockData->stock_code,
                'sale_detail_stock_name' => $stockData->stock_name,
                'sale_detail_stock_category_id' => $stockData->stock_category_id,
                'sale_detail_stock_category_name' => $stockData->category->category_name,
                'sale_detail_stock_unit' => $stockData->stock_unit,
                'sale_detail_cost_price' => $stockData->stock_purchase_price,
                'sale_detail_price' => floatval($item['price']) * (1 - $item['discount'] / 100),
                'sale_detail_quantity' => $item['quantity'],
                'sale_detail_total_price' => $item['quantity'] * $item['price'],
                'sale_detail_discount' => intval($item['discount']),
                'sale_detail_discount_amount' =>
                    floatval($item['price']) * intval($item['quantity']) * ($item['discount'] / 100),
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
            $stock = $stocks[$item['id']];
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
