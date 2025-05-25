<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerCredit extends Model
{
    public const PAID_STATUS = 1;
    public const UNPAID_STATUS = 0;

    protected $table = 'tbl_customer_credits';

    protected $primaryKey = 'customer_credit_id';

    protected $fillable = [
        'customer_credit_customer_id',
        'customer_credit_invoice',
        'customer_credit_total_purchase',
        'customer_credit_total_payment',
        'customer_credit',
        'customer_credit_status'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_credit_customer_id', 'customer_id');
    }
}
