<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'tbl_regions';

    protected $primaryKey = 'region_id';

    protected $fillable = [
        'region_code',
        'region_name'
    ];
}
