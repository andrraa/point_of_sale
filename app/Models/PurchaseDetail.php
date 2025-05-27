<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseDetail extends Model
{
    protected $table = 'tbl_purchase_details';

    protected $primaryKey = 'purchase_detail_id';

    protected $fillable = [
        'purchase_detail_purchase_id',
        'purchase_detail_stock_id',
        'purchase_detail_stock_code',
        'purchase_detail_stock_name',
        'purchase_detail_stock_category_id',
        'purchase_detail_stock_category_name',
        'purchase_detail_stock_unit',
        'purchase_detail_cost_price',
        'purchase_detail_price',
        'purchase_detail_quantity',
        'purchase_detail_total_price'
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'purchase_detail_stock_id', 'stock_id');
    }
}
