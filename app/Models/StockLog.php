<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    protected $table = 'tbl_stock_logs';
    protected $primaryKey = 'stock_log_id';
    protected $fillable = [
        'stock_log_stock_id',
        'stock_log_quantity',
        'stock_log_description',
        'stock_log_user_id'
    ];
}
