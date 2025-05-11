<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'tbl_stocks';

    protected $primaryKey = 'stock_id';
}
