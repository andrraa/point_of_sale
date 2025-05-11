<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'tbl_purchases';

    protected $primaryKey = 'purchase_id';
}
