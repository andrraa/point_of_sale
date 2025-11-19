<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $supplier = request()->route('supplier_stock');

        return [
            'ss_name' => [
                'required',
                'string',
                Rule::unique('tbl_supplier_stocks', 'ss_name')
                    ->ignore(optional($supplier)->ss_id, 'ss_id')
            ],
            'ss_phone' => [
                'required',
                'string',
            ],
            'ss_address' => [
                'nullable',
                'string'
            ],
            'ss_description' => [
                'nullable',
                'string'
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'ss_name' => 'nama supplier',
            'ss_phone' => 'nomor handphone supplier',
            'ss_address' => 'alamat supplier',
            'ss_description' => 'keterangan supplier'
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'ss_name' => ucwords(strtolower($this->ss_name))
        ]);
    }
}
