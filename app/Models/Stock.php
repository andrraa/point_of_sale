<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $table = 'tbl_stocks';

    protected $primaryKey = 'stock_id';

    protected $fillable = [
        'stock_code',
        'stock_name',
        'stock_category_id',
        'stock_unit',
        'stock_purchase_price',
        'stock_sale_price_1',
        'stock_sale_price_2',
        'stock_sale_price_3',
        'stock_sale_price_4',
        'stock_total',
        'stock_current',
        'stock_in',
        'stock_out'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'stock_category_id', 'category_id');
    }
}
