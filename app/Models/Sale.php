<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public const PAID_STATUS = 1;
    public const CANCEL_STATUS = 0;
    public const CREDIT_STATUS = 5;

    protected $table = 'tbl_sales';

    protected $primaryKey = 'sale_id';

    protected $fillable = [
        'sales_invoice',
        'sales_customer_id',
        'sales_payment_type',
        'sales_total_price',
        'sales_total_payment',
        'sales_total_change',
        'sales_discount',
        'sales_total_discount',
        'sales_status'
    ];
}
