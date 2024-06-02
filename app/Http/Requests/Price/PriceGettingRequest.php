<?php

namespace App\Http\Requests\Price;

use Illuminate\Foundation\Http\FormRequest;

class PriceGettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type_ids' => ['required', 'array'],
            'type_ids.*' => ['integer', 'exists:invTypes,typeID'],
        ];
    }
}
