<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'store_name' => [
                'required',
                'string',
                'max:50'
            ],
            'store_address' => [
                'required',
                'string',
                'max:150'
            ],
            'store_phone_number' => [
                'required',
                'numeric'
            ]
        ];
    }
}
