<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sale extends Model
{
    public const PAID_STATUS = 1;
    public const CANCEL_STATUS = 0;
    public const CREDIT_STATUS = 5;

    protected $table = 'tbl_sales';

    protected $primaryKey = 'sales_id';

    protected $fillable = [
        'sales_invoice',
        'sales_customer_id',
        'sales_payment_type',
        'sales_total_price',
        'sales_total_gross',
        'sales_total_payment',
        'sales_total_change',
    ];

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->translatedFormat('d F Y, H:i');
    }

    public function details(): HasMany
    {
        return $this->hasMany(SaleDetail::class, 'sale_detail_sales_id', 'sales_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'sales_customer_id', 'customer_id');
    }

    public function credit(): HasOne
    {
        return $this->hasOne(CustomerCredit::class, 'customer_credit_sales_id', 'sales_id');
    }
}
