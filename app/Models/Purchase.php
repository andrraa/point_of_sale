<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    protected $table = 'tbl_purchases';

    protected $primaryKey = 'purchase_id';

    protected $fillable = [
        'purchase_invoice',
        'purchase_supplier_id',
        'purchase_region_id',
        'purchase_description'
    ];

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->translatedFormat('d M Y, H:i');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'purchase_supplier_id', 'supplier_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'purchase_region_id', 'region_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_detail_purchase_id', 'purchase_id');
    }
}
