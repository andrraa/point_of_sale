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
                'string'
            ],
            'stock_sale_price_1' => [
                'required',
                'string'
            ],
            'stock_sale_price_2' => [
                'required',
                'string'
            ],
            'stock_sale_price_3' => [
                'required',
                'string'
            ],
            'stock_total' => [
                'required',
                'integer',
            ],
            'stock_in' => [
                'required',
                'integer',
            ],
            'stock_out' => [
                'required',
                'integer',
            ],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'stock_name' => strtoupper(strtolower($this->stock_name)),
            'stock_purchase_price' => str_replace('.', '', $this->stock_purchase_price),
            'stock_sale_price_1' => str_replace('.', '', $this->stock_sale_price_1),
            'stock_sale_price_2' => str_replace('.', '', $this->stock_sale_price_2),
            'stock_sale_price_3' => str_replace('.', '', $this->stock_sale_price_3),
            'stock_sale_price_4' => str_replace('.', '', $this->stock_sale_price_4),
            'stock_total' => $this->stock_total ?? 0,
            'stock_in' => $this->stock_in ?? 0,
            'stock_out' => $this->stock_out ?? 0
        ]);
    }
}
