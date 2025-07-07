<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockTakenRequest extends FormRequest
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
                'exists:tbl_stocks,stock_code'
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],
            'description' => [
                'nullable',
                'string'
            ]
        ];
    }
}
