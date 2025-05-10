<?php

namespace App\Http\Requests;

use Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tbl_users', 'username')->ignore($this->route('user')->user_id ?? null, 'user_id')
            ],
            'password' => [
                'nullable',
                'max:255'
            ],
            'active' => [
                'required',
                'integer',
                'in:0,1'
            ]
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'password' => request()->isMethod('post') && $this->password ?? Hash::make(Str::random(8))
        ]);
    }
}
