<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type_category' => [
                'required',
                'integer',
                'in:1,2'
            ],
            'stock_category' => [
                'required',
            ],
            'start_date' => [
                'required',
                'date'
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date'
            ]
        ];
    }
}
