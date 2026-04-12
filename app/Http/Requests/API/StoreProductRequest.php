<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'tag_line_1' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'tag_line_2' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_1' => 'nullable|image|max:5120',
            'image_2' => 'nullable|image|max:5120',
            'image_3' => 'nullable|image|max:5120',
            'image_4' => 'nullable|image|max:5120',
            'image_5' => 'nullable|image|max:5120',
            'ingredients' => 'nullable|array',
            'ingredients.*.name' => 'nullable|string|max:255',
            'ingredients.*.image' => 'nullable',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'nullable|string',
            'faqs.*.answer' => 'nullable|string',
            'status' => 'nullable|boolean',
            'variants' => 'required|array|min:1',
            'variants.*.name' => 'required_with:variants|string|max:255',
            'variants.*.sku' => 'required_with:variants|string|max:100|distinct|unique:product_variants,sku',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
            'variants.*.discount_price' => 'nullable|numeric|min:0',
            'variants.*.weight' => 'nullable|string|max:255',
            'variants.*.brewing_rituals' => 'nullable|array',
            'variants.*.brewing_rituals.*.ritual' => 'nullable|string|max:255',
            'variants.*.brewing_rituals.*.image' => 'nullable',
            'variants.*.is_default' => 'nullable|boolean',
            'variants.*.status' => 'nullable|boolean',
        ];
    }
}
