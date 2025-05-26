<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetail extends Model
{
    protected $table = 'tbl_sale_details';

    protected $primaryKey = 'sale_detail_id';

    protected $fillable = [
        'sale_detail_sales_id',
        'sale_detail_stock_id',
        'sale_detail_stock_code',
        'sale_detail_stock_name',
        'sale_detail_stock_category_id',
        'sale_detail_stock_category_name',
        'sale_detail_stock_unit',
        'sale_detail_cost_price',
        'sale_detail_price',
        'sale_detail_quantity',
        'sale_detail_total_price'
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'sale_detail_stock_id', 'stock_id');
    }
}
