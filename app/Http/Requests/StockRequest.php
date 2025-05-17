<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stock_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tbl_stocks', 'stock_code')
                    ->ignore($this->route('stock')->stock_id ?? null, 'stock_id')
            ],
            'stock_name' => [
                'required',
                'string',
                'max:100'
            ],
            'stock_category_id' => [
                'required',
                'integer',
                'exists:tbl_categories,category_id'
            ],
            'stock_unit' => [
                'required',
                'string',
                'max:5'
            ],
            'stock_purchase_price' => [
                'required',
                'numeric'
            ],
            'stock_sale_price_1' => [
                'required',
                'numeric'
            ],
            'stock_sale_price_2' => [
                'required',
                'numeric'
            ],
            'stock_sale_price_3' => [
                'required',
                'numeric'
            ],
            'stock_sale_price_4' => [
                'required',
                'numeric'
            ]
        ];
    }
}
