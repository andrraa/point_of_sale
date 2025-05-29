<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('tbl_categories', 'category_code')
                    ->ignore($this->route('category')->category_id ?? null, 'category_id')
            ],
            'category_name' => [
                'required',
                'string',
                'max:50'
            ],
            'category_type' => [
                'required',
            ],
            'category_price_level' => [
                'required',
                'integer',
                'in:1,2,3'
            ]
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'category_name' => strtoupper($this->category_name),
            'category_type' => $this->category_type === 'Barang' ? 1 : 0
        ]);
    }
}
