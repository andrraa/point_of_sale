<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockTakenReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stock_category' => [
                'required'
            ],
            'start_date' => [
                'required',
                'date'
            ],
            'end_date' => [
                'required',
                'after_or_equal:start_date'
            ]
        ];
    }
}
