<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
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
            'action' => [
                'required',
                'string',
                'in:increment,decrement', // Only allow these two actions
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     * Sanitize inputs before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('action')) {
            $this->merge([
                'action' => strtolower(trim($this->action)),
            ]);
        }
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'action.required' => 'Action is required.',
            'action.in' => 'Invalid action. Only increment or decrement allowed.',
        ];
    }
}
