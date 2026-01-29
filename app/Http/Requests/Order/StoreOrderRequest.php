<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
     * Comprehensive security validation for checkout.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Customer Information
            'full_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[\p{L}\s\-\.]+$/u', // Only letters, spaces, hyphens, dots (supports Arabic)
            ],
            
            'email' => [
                'nullable',
                'email:rfc,dns',
                'max:255',
            ],
            
            'phone' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^[\d\s\+\-\(\)]+$/', // Only digits, spaces, +, -, ()
            ],
            
            'another_phone' => [
                'nullable',
                'string',
                'min:8',
                'max:20',
                'regex:/^[\d\s\+\-\(\)]+$/',
            ],
            
            // Address Information
            'address' => [
                'required',
                'string',
                'min:10',
                'max:500',
            ],
            
            'city_id' => [
                'nullable',
                'integer',
                'exists:cities,id',
            ],
            
            'area_id' => [
                'nullable',
                'integer',
                'exists:cities,id',
            ],
            
            // Payment Information
            'payment_method' => [
                'required',
                'string',
                Rule::in(['cash', 'visa', 'instapay']),
            ],
            
            // Order Total (will be recalculated server-side for security)
            'total' => [
                'required',
                'numeric',
                'min:0',
                'max:1000000', // Max 1 million
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     * Sanitize all inputs before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            // Sanitize full_name - remove extra spaces and HTML
            'full_name' => $this->sanitizeString($this->full_name),
            
            // Sanitize email
            'email' => $this->email ? strtolower(trim($this->email)) : null,
            
            // Sanitize phone - keep only valid phone characters
            'phone' => $this->sanitizePhone($this->phone),
            'another_phone' => $this->another_phone ? $this->sanitizePhone($this->another_phone) : null,
            
            // Sanitize address
            'address' => $this->sanitizeString($this->address),
            
            // Ensure payment method is lowercase
            'payment_method' => $this->payment_method ? strtolower(trim($this->payment_method)) : null,
            
            // Ensure total is numeric
            'total' => (float) abs($this->total ?? 0),
            
            // Ensure IDs are integers
            'city_id' => $this->city_id ? (int) $this->city_id : null,
            'area_id' => $this->area_id ? (int) $this->area_id : null,
        ]);
    }

    /**
     * Sanitize a string input.
     */
    private function sanitizeString(?string $value): ?string
    {
        if (!$value) {
            return null;
        }
        
        // Remove HTML tags
        $value = strip_tags($value);
        
        // Remove multiple spaces
        $value = preg_replace('/\s+/', ' ', $value);
        
        // Trim
        return trim($value);
    }

    /**
     * Sanitize phone number.
     */
    private function sanitizePhone(?string $value): ?string
    {
        if (!$value) {
            return null;
        }
        
        // Keep only digits, +, -, spaces, parentheses
        return preg_replace('/[^\d\s\+\-\(\)]/', '', $value);
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // Full Name
            'full_name.required' => 'Full name is required.',
            'full_name.min' => 'Full name must be at least 3 characters.',
            'full_name.max' => 'Full name cannot exceed 100 characters.',
            'full_name.regex' => 'Full name can only contain letters, spaces, hyphens, and dots.',
            
            // Email
            'email.email' => 'Please enter a valid email address.',
            
            // Phone
            'phone.required' => 'Phone number is required.',
            'phone.min' => 'Phone number must be at least 8 digits.',
            'phone.max' => 'Phone number cannot exceed 20 digits.',
            'phone.regex' => 'Phone number contains invalid characters.',
            
            // Address
            'address.required' => 'Address is required.',
            'address.min' => 'Address must be at least 10 characters.',
            'address.max' => 'Address cannot exceed 500 characters.',
            
            // City/Area
            'city_id.exists' => 'Selected city is invalid.',
            'area_id.exists' => 'Selected area is invalid.',
            
            // Payment
            'payment_method.required' => 'Payment method is required.',
            'payment_method.in' => 'Invalid payment method selected.',
            
            // Total
            'total.required' => 'Order total is required.',
            'total.numeric' => 'Order total must be a number.',
            'total.min' => 'Order total cannot be negative.',
        ];
    }
}
