<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public const CATEGORY_CUSTOMER = 0;
    public const ITEM_CATEGORY = 1;

    protected $table = 'tbl_categories';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_code',
        'category_name',
        'category_type'
    ];
}
