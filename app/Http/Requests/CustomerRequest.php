<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_category_id' => [
                'required',
                'integer',
                'exists:tbl_categories,category_id'
            ],
            'customer_name' => [
                'required',
                'string',
                'max:100'
            ],
            'customer_address' => [
                'nullable',
                'string'
            ],
            'customer_region_id' => [
                'required',
                'integer',
                'exists:tbl_regions,region_id'
            ],
            'customer_phone_number' => [
                'nullable',
                'string',
                'max:50'
            ],
            'customer_npwp_number' => [
                'nullable',
                'string',
                'max:50'
            ],
            'customer_credit_limit' => [
                'required',
                'string'
            ]
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'customer_name' => ucwords(strtolower($this->customer_name)),
            'customer_credit_limit' => str_replace('.', '', $this->customer_credit_limit ?? 0),
            'customer_address' => ucwords(strtolower($this->customer_address)),
        ]);
    }
}
