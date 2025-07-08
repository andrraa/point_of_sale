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
            'customerId' => [
                'required',
                'integer',
                'exists:tbl_customers,customer_id'
            ],
            'customerPay' => [
                'required',
                'numeric'
            ],
            'customerDebt' => [
                'required',
                'numeric'
            ],
            'items' => [
                'required',
                'array'
            ],
        ];
    }
}
