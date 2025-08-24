<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
            'category_id'         => 'required|exists:categories,id',
            'title'         => 'required|array',
            'title.*'       => [
                'required',
                'string',
                'max:255',
                // \CodeZero\UniqueTranslation\UniqueTranslationRule::for('products')->ignore($this->id)
            ],
            'description'   => 'required|array',
            'description.*' => 'required|string|max:1000',
            'content'       => 'required|array',
            'old_price'     => 'required|numeric',
            'price'         => 'required|numeric',
            'content.*'     => 'required|string|max:1000',
            'position'      => 'required',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'images'        => 'nullable|array|max:10',
            'images.*'      => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'active'        => 'required|in:0,1',
        ];
    }
}
