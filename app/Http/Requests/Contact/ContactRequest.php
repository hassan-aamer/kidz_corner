<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Egyptian phone prefixes (mobile operators)
     * 010 - Vodafone
     * 011 - Etisalat
     * 012 - Orange
     * 015 - WE
     */
    private const EGYPTIAN_PHONE_REGEX = '/^(010|011|012|015)\d{8}$/';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * - Email: Gmail only (@gmail.com)
     * - Phone: Egyptian mobile numbers only (010, 011, 012, 015)
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[\p{L}\s\-\.]+$/u', // Letters only (Arabic/English)
            ],
            
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i', // Gmail only
            ],
            
            'phone' => [
                'required',
                'string',
                'regex:' . self::EGYPTIAN_PHONE_REGEX, // Egyptian numbers only
            ],
            
            'message' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
            
            'active' => 'nullable|in:0,1',
        ];
    }

    /**
     * Prepare the data for validation.
     * Sanitize all inputs.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            // Sanitize name
            'name' => $this->sanitizeString($this->name),
            
            // Sanitize email - lowercase and trim
            'email' => $this->email ? strtolower(trim($this->email)) : null,
            
            // Sanitize phone - remove all non-digits
            'phone' => $this->sanitizePhone($this->phone),
            
            // Sanitize message
            'message' => $this->sanitizeString($this->message),
        ]);
    }

    /**
     * Sanitize string input.
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
        
        return trim($value);
    }

    /**
     * Sanitize phone number.
     * Keeps only digits and handles Egyptian format.
     */
    private function sanitizePhone(?string $value): ?string
    {
        if (!$value) {
            return null;
        }
        
        // Remove all non-digits
        $digits = preg_replace('/\D/', '', $value);
        
        // Handle +20 country code
        if (str_starts_with($digits, '20') && strlen($digits) === 12) {
            $digits = substr($digits, 2); // Remove 20, keep 10 digits
        }
        
        // Handle 00020 format
        if (str_starts_with($digits, '002') && strlen($digits) === 13) {
            $digits = substr($digits, 3); // Remove 002, keep 10 digits
        }
        
        return $digits;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // Name
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 3 characters.',
            'name.max' => 'Name cannot exceed 100 characters.',
            'name.regex' => 'Name can only contain letters, spaces, and hyphens.',
            
            // Email
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.regex' => 'Only Gmail addresses (@gmail.com) are allowed.',
            
            // Phone
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Please enter a valid Egyptian phone number (e.g., 01012345678).',
            
            // Message
            'message.required' => 'Message is required.',
            'message.min' => 'Message must be at least 10 characters.',
            'message.max' => 'Message cannot exceed 2000 characters.',
        ];
    }

    /**
     * Get custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'name' => 'name',
            'email' => 'email address',
            'phone' => 'phone number',
            'message' => 'message',
        ];
    }
}

