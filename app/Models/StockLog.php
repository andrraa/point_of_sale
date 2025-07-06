<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockLog extends Model
{
    public const OUT_STATUS = 0;
    public const IN_STATUS = 1;

    protected $table = 'tbl_stock_logs';
    protected $primaryKey = 'stock_log_id';
    protected $fillable = [
        'stock_log_stock_id',
        'stock_log_quantity',
        'stock_log_description',
        'stock_log_user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'stock_log_user_id', 'user_id');
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'stock_log_stock_id', 'stock_id');
    }

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('d M Y, H:i');
    }
}
