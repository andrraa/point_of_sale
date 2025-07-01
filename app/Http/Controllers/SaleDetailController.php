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
                'stock_current' => $stock->stock_current + $difference,
                'stock_in' => $stock->stock_in + $difference,
                'stock_out' => $stock->stock_out - $difference
            ]);
        } elseif ($newQuantity > $oldQuantity) {
            $difference = $newQuantity - $oldQuantity;

            if ($stock->stock_current < $difference) {
                DB::rollBack();
                return response()->json(false);
            }

            $stock->update([
                'stock_current' => $stock->stock_current - $difference,
                'stock_out' => $stock->stock_out + $difference,
                'stock_in' => $stock->stock_in - $difference
            ]);
        }

        DB::commit();

        return response()->json(true);
    }

    public function destroy(SaleDetail $saleDetail): JsonResponse
    {
        abort_unless(request()->expectsJson(), 403);

        $stock = Stock::firstWhere('stock_id', $saleDetail->sale_detail_stock_id);

        $stock->update([
            'stock_current' => $stock->stock_current + $saleDetail->sale_detail_quantity,
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
