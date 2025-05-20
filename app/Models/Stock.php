<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

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
        'stock_total',
        'stock_current',
        'stock_in',
        'stock_out'
    ];

    public static function getStockDropdown(): Collection
    {
        return self::query()
            ->select(['stock_id', 'stock_name'])
            ->pluck('stock_name', 'stock_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'stock_category_id', 'category_id');
    }
}
