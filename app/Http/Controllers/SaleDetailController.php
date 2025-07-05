<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleDetailRequest;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SaleDetailController
{
    public function update(SaleDetailRequest $request, SaleDetail $saleDetail): JsonResponse
    {
        $newQuantity = $request->validated()['quantity'];
        $oldQuantity = $saleDetail->sale_detail_quantity;

        DB::beginTransaction();

        $saleDetail->update([
            'sale_detail_quantity' => $newQuantity,
            'sale_detail_total_price' => $saleDetail->sale_detail_price * $newQuantity
        ]);

        $stock = Stock::firstWhere('stock_id', $saleDetail->sale_detail_stock_id);

        if ($newQuantity < $oldQuantity) {
            $difference = $oldQuantity - $newQuantity;

            $stock->update([
                'stock_in' => $stock->stock_in + $difference,
                'stock_out' => $stock->stock_out - $difference
            ]);
        } elseif ($newQuantity > $oldQuantity) {
            $difference = $newQuantity - $oldQuantity;

            $stock->update([
                'stock_out' => $stock->stock_out + $difference,
                'stock_in' => $stock->stock_in - $difference
            ]);
        }

        $saleId = $saleDetail->sale_detail_sales_id;

        $saleDetails = SaleDetail::where('sale_detail_sales_id', $saleId)->get();

        $totalGross = 0;
        $totalPrice = 0;

        foreach ($saleDetails as $detail) {
            $quantity = $detail->sale_detail_quantity;
            $price = floatval($detail->sale_detail_price);
            $discount = intval($detail->sale_detail_discount);

            $subtotal = $price * $quantity;
            $discountAmount = $subtotal * ($discount / 100);

            $totalGross += $subtotal;
            $totalPrice += $subtotal - $discountAmount;
        }

        $sale = Sale::findOrFail($saleId);

        $totalChange = 0;
        $totalDebt = 0;

        if ($sale->sales_total_payment >= $totalPrice) {
            $totalChange = $sale->sales_total_payment - $totalPrice;
        } else {
            $totalDebt = $totalPrice - $sale->sales_total_payment;
        }

        $paymentType = $totalDebt > 0 ? 'credit' : 'cash';

        $sale->update([
            'sales_total_price' => $totalPrice,
            'sales_total_gross' => $totalGross,
            'sales_total_change' => $totalChange,
            'sales_payment_type' => $paymentType,
            'sales_status' => $totalDebt > 0 ? Sale::CREDIT_STATUS : Sale::PAID_STATUS,
        ]);

        DB::commit();

        return response()->json(true);
    }

    public function destroy(SaleDetail $saleDetail): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        $stock = Stock::firstWhere('stock_id', $saleDetail->sale_detail_stock_id);

        $stock->update([
            'stock_out' => $stock->stock_out - $saleDetail->sale_detail_quantity,
            'stock_in' => $stock->stock_in + $saleDetail->sale_detail_quantity
        ]);

        $sale = $saleDetail->sale;

        $saleDetail->delete();

        $remaining = $sale->details()->count();

        if ($remaining === 0) {
            $sale->update([
                'sales_status' => Sale::CANCEL_STATUS
            ]);
        }

        return response()->json(true);
    }
}
