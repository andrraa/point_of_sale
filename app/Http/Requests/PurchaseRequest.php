<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purchase_invoice' => [
                'required',
                'string',
                'max:100',
                Rule::unique('tbl_purchases', 'purchase_invoice')
                    ->ignore($this->route('purchase')->purchase_id ?? null, 'purchase_id')
            ],
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
            'purchase_items' => [
                'required',
                'array'
            ]
        ];
    }
}
