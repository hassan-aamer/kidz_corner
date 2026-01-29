<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
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
            'quantity' => [
                'nullable',
                'integer',
                'min:1',
                'max:100', // Maximum 100 items per add
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     * Sanitize inputs before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('quantity')) {
            $this->merge([
                'quantity' => (int) abs($this->quantity),
            ]);
        }
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'quantity.integer' => 'Quantity must be a valid number.',
            'quantity.min' => 'Quantity must be at least 1.',
            'quantity.max' => 'Maximum quantity is 100.',
        ];
    }
}
