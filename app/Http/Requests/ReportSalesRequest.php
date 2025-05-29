<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportSalesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sale_start_date' => [
                'required',
                'date'
            ],
            'sale_end_date' => [
                'required',
                'date'
            ],
            'sale_type' => [
                'required',
                'string',
                'in:detail,analyse'
            ],
            // 'sale_category' => [
            //     'nullable',
            //     'integer'
            // ]
        ];
    }
}
