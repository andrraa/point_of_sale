<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $table = 'tbl_purchase_details';

    protected $primaryKey = 'p_detail_id';

    protected $fillable = [
        'purchase_invoice',
        'purchase_supplier_id',
        'purchase_region_id',
        'purchase_description'
    ];
}
