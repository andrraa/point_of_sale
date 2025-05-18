<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('tbl_suppliers', 'supplier_code')
                    ->ignore($this->route('supplier')->supplier_id ?? null, 'supplier_id')
            ],
            'supplier_name' => [
                'required',
                'string',
                'max:100'
            ],
            'supplier_address' => [
                'required',
                'string',
                'max:255'
            ],
            'supplier_region_id' => [
                'required',
                'integer',
                'exists:tbl_regions,region_id'
            ],
            'supplier_contact_person' => [
                'nullable',
                'string',
                'max:100'
            ],
            'supplier_telepon_number' => [
                'nullable',
                'string',
                'max:100'
            ],
            'supplier_handphone_number' => [
                'nullable',
                'string',
                'max:100'
            ],
            'supplier_npwp_number' => [
                'nullable',
                'string',
                'max:100'
            ],
            'supplier_last_buy' => [
                'nullable',
                'string',
                'max:100'
            ],
            'supplier_last_debt' => [
                'nullable',
                'string',
            ],
            'supplier_first_debt' => [
                'nullable',
                'string',
            ],
            'supplier_purchase' => [
                'nullable',
                'string',
            ],
            'supplier_payment' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'supplier_name' => strtoupper(strtolower($this->supplier_name)),
            'supplier_address' => strtoupper(strtolower($this->supplier_address)),
            'supplier_contact_person' => strtoupper(strtolower($this->supplier_contact_person)),
            'supplier_last_debt' => str_replace('.', '', $this->supplier_last_debt),
            'supplier_first_debt' => str_replace('.', '', $this->supplier_first_debt),
            'supplier_purchase' => str_replace('.', '', $this->supplier_purchase),
            'supplier_payment' => str_replace('.', '', $this->supplier_payment),
        ]);
    }
}
