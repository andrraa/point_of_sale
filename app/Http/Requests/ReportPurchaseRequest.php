<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportPurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purchase_start_date' => [
                'required',
                'date'
            ],
            'purchase_end_date' => [
                'required',
                'date'
            ],
            'purchase_type' => [
                'required',
                'string',
                'in:detail,analyse'
            ],
            // 'purchase_category' => [
            //     'required',
            //     'integer'
            // ]
        ];
    }
}
