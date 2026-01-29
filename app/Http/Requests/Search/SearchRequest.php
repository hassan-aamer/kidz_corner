<?php

namespace App\Http\Requests\Search;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
     * Strong security validation for search input.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => [
                'nullable',
                'string',
                'max:100', // Limit search length
                // Block potential SQL injection patterns
                'not_regex:/(\bunion\b|\bselect\b|\binsert\b|\bupdate\b|\bdelete\b|\bdrop\b|\btruncate\b|--|;|\/\*|\*\/)/i',
            ],
            'page' => [
                'nullable',
                'integer',
                'min:1',
                'max:1000',
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     * Sanitize search input before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('search')) {
            $search = $this->search;

            // Remove HTML tags
            $search = strip_tags($search);

            // Remove potential script injection
            $search = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $search);

            // Remove multiple spaces
            $search = preg_replace('/\s+/', ' ', $search);

            // Trim and limit length
            $search = mb_substr(trim($search), 0, 100);

            // Remove null bytes
            $search = str_replace("\0", '', $search);

            $this->merge([
                'search' => $search,
            ]);
        }

        // Ensure page is integer
        if ($this->has('page')) {
            $this->merge([
                'page' => (int) abs($this->page),
            ]);
        }
    }

    /**
     * Get the sanitized search term.
     * Returns empty string if search is invalid or empty.
     */
    public function getSearchTerm(): string
    {
        return $this->validated()['search'] ?? '';
    }

    /**
     * Get the page number.
     */
    public function getPage(): int
    {
        return $this->validated()['page'] ?? 1;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'search.max' => 'Search term cannot exceed 100 characters.',
            'search.not_regex' => 'Search contains invalid characters.',
            'page.integer' => 'Invalid page number.',
            'page.min' => 'Page number must be at least 1.',
        ];
    }
}
