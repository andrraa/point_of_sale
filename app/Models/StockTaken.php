<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockTaken extends Model
{
    protected $table = 'tbl_stock_takens';
    protected $primaryKey = 'stock_taken_id';
    protected $fillable = [
        'stock_taken_stock_id',
        'stock_taken_stock_code',
        'stock_taken_stock_name',
        'stock_taken_quantity',
        'stock_taken_price',
        'stock_taken_description',
        'stock_taken_category_id',
        'stock_taken_user_id'
    ];

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('d M Y, h:i');
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'stock_taken_stock_id', 'stock_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'stock_taken_user_id', 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'stock_taken_category_id', 'category_id');
    }
}
