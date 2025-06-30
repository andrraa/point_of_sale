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
            'full_name' => [
                'required',
                'string',
                'max:255'
            ],
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tbl_users', 'username')
                    ->ignore($this->route('user')->user_id ?? null, 'user_id')
            ],
            'password' => [
                'nullable',
                'max:255'
            ],
            'active' => [
                'required',
                'integer',
                'in:0,1'
            ],
            'user_role_id' => [
                'required',
                'integer',
                'exists:tbl_roles,role_id'
            ]
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'full_name' => ucwords(strtolower($this->full_name)),
            'username' => strtolower($this->username)
        ]);
    }
}
