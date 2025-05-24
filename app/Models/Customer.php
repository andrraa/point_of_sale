<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Customer extends Model
{
    public $customerDropdownCache = 'customer_dropdown_cache';

    public const CUSTOMER_GENERAL_PRICE = 11;
    public const CUSTOMER_GROCIER_PRICE = 12;
    public const CUSTOMER_WAREHOUSE_PRICE = 13;

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

    public static function getCustomerDropdown(): Collection
    {
        return self::query()
            ->select(['customer_id', 'customer_name'])
            ->pluck('customer_name', 'customer_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'customer_category_id', 'category_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'customer_region_id', 'region_id');
    }
}
