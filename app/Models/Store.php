<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'tbl_store';
    protected $primaryKey = 'store_id';
    protected $fillable = [
        'store_name',
        'store_address',
        'store_phone_number'
    ];
}
