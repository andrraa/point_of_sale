<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class SupplierStock extends Model
{
    use SoftDeletes;
    
    protected $table = "tbl_supplier_stocks";
    protected $primaryKey = "ss_id";
    protected $fillable = [
        'ss_name',
        'ss_phone',
        'ss_address',
        'ss_description'
    ];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'stock_ss_id', 'ss_id');
    }

    public static function getSupplierStockDropdown(): Collection
    {
        return self::query()
            ->select(['ss_id', 'ss_name'])
            ->pluck('ss_name', 'ss_id');
    }
}
