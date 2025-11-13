<?php

namespace App\Http\Requests\Banners;

use Illuminate\Foundation\Http\FormRequest;

class BannersRequest extends FormRequest
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
            'category_id'         => 'nullable|exists:categories,id',
            'title'    => 'nullable|array',
            'title.*'       => [
                'nullable',
                'string',
                'max:255',
                \CodeZero\UniqueTranslation\UniqueTranslationRule::for('banners')->ignore($this->id)
            ],
            'position' => 'required',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'active'   => 'required|in:0,1',
        ];
    }
}
