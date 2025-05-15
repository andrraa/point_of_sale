<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'region_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('tbl_regions', 'region_code')
                    ->ignore($this->route('region')->region_id ?? null, 'region_id')
            ],
            'region_name' => [
                'required',
                'string',
                'max:50'
            ]
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'region_name' => strtoupper($this->region_name)
        ]);
    }
}
