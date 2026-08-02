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
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'caffeine' => 'nullable|in:low,medium,caffeine_free',
            'collection' => 'nullable|string',
            'image_1' => 'nullable|image|max:5120',
            'image_2' => 'nullable|image|max:5120',
            'image_3' => 'nullable|image|max:5120',
            'image_4' => 'nullable|image|max:5120',
            'image_5' => 'nullable|image|max:5120',
            'ingredients' => 'nullable|string',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'nullable|string',
            'faqs.*.answer' => 'nullable|string',
            'brewing_rituals' => 'nullable|array',
            'brewing_rituals.note' => 'nullable|string',
            'brewing_rituals.hot_brew' => 'nullable|array',
            'brewing_rituals.hot_brew.*.label' => 'nullable|string|max:255',
            'brewing_rituals.hot_brew.*.value' => 'nullable|string|max:255',
            'brewing_rituals.iced_brew' => 'nullable|array',
            'brewing_rituals.iced_brew.*.label' => 'nullable|string|max:255',
            'brewing_rituals.iced_brew.*.value' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'variants' => 'required|array|min:1',
            'variants.*.name' => 'required_with:variants|string|max:255',
            'variants.*.sku' => 'required_with:variants|string|max:100|distinct|unique:product_variants,sku',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
            'variants.*.discount_price' => 'nullable|numeric|min:0',
            'variants.*.weight' => 'nullable|string|max:255',
            'variants.*.product_dimension' => 'nullable|string|max:255',
            'variants.*.item_form' => 'nullable|string|max:255',
            'variants.*.is_default' => 'nullable|boolean',
            'variants.*.status' => 'nullable|boolean',
        ];
    }
}
