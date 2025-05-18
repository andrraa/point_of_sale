<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Supplier extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_suppliers';

    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_code',
        'supplier_name',
        'supplier_address',
        'supplier_region_id',
        'supplier_contact_person',
        'supplier_telepon_number',
        'supplier_handphone_number',
        'supploer_npwp_number',
        'supploer_last_buy',
        'supplier_first_debt',
        'supplier_last_debt',
        'supplier_purchase',
        'supplier_payment',
    ];

    public static function getSupplierDropdown(): Collection
    {
        return self::query()
            ->select(['supplier_id', 'supplier_name'])
            ->pluck('supplier_name', 'supplier_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'supplier_region_id', 'region_id');
    }
}
