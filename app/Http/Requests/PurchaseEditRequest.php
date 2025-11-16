<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purchase_supplier_id' => [
                'required',
                'integer',
                'exists:tbl_suppliers,supplier_id'
            ],
            'purchase_region_id' => [
                'required',
                'integer',
                'exists:tbl_regions,region_id'
            ],
            'purchase_description' => [
                'nullable',
                'string',
            ],
        ];
    }
}
