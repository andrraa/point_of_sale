<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
        'stock_in',
        'stock_out'
    ];

    public static function getStockDropdown(): Collection
    {
        return self::query()
            ->select(['stock_id', 'stock_name'])
            ->pluck('stock_name', 'stock_id');
    }

    public static function getConcatedStockDropdown(): Collection
    {
        return self::query()
            ->select([
                'stock_id',
                DB::raw("CONCAT(stock_name, ' (Stock: ', stock_total, ')') as stock_label")
            ])
            ->where('stock_total', '>', 0)
            ->pluck('stock_label', 'stock_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'stock_category_id', 'category_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(StockLog::class, 'stock_log_stock_id', 'stock_id');
    }
}
