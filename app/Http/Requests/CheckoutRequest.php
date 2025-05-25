<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => [
                'required',
                'integer',
                'exists:tbl_customers,customer_id'
            ],
            'payment_type' => [
                'required',
                'string',
                'in:credit,cash'
            ],
            'total_payment' => [
                'required',
                'numeric'
            ],
            'discount' => [
                'required',
                'numeric'
            ],
            'items' => [
                'required',
                'array'
            ],
            'is_credit' => [
                'required',
                'integer',
                'in:0,1'
            ]
        ];
    }
}
