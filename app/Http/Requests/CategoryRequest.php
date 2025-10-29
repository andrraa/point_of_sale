<?php

namespace App\Http\Requests;

use App\Models\Category;
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
                'nullable',
                'integer',
                'in:1,2,3'
            ]
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'category_name' => strtoupper($this->category_name),
            'category_type' => match ($this->category_type) {
                'Barang' => Category::ITEM_CATEGORY,
                'Pelanggan' => Category::CATEGORY_CUSTOMER,
                'Rak' => Category::RACK_CATEGORY,
                default => Category::CATEGORY_CUSTOMER,
            },
        ]);
    }
}
