<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $table = 'tbl_customers';

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_category_id',
        'customer_name',
        'customer_address',
        'customer_region_id',
        'customer_telepon_number',
        'customer_npwp_number',
        'customer_credit_limit',
        'customer_status'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'customer_category_id', 'category_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'customer_region_id', 'region_id');
    }
}
