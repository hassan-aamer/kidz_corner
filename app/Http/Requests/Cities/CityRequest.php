<?php

namespace App\Http\Requests\Cities;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'    => 'nullable|array',
            'title.*'       => [
                'required',
                'string',
                'max:255',
                \CodeZero\UniqueTranslation\UniqueTranslationRule::for('cities')->ignore($this->id)
            ],
            'position' => 'required',
            'shipping_price' => 'required',
            'active'   => 'required|in:0,1',
        ];
    }
}
