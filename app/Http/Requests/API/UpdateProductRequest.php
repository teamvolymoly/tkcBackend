<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('id') ?? $this->route('product');

        return [
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'tag_line_1' => 'nullable|string|max:255',
            'name' => 'sometimes|required|string|max:255',
            'tag_line_2' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'caffeine' => 'nullable|in:low,medium,caffeine_free',
            'collection' => 'nullable|string',
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
            'brewing_rituals' => 'nullable|array',
            'brewing_rituals.hot_brew' => 'nullable|array',
            'brewing_rituals.hot_brew.*.ritual' => 'nullable|string|max:255',
            'brewing_rituals.hot_brew.*.image' => 'nullable',
            'brewing_rituals.iced_brew' => 'nullable|array',
            'brewing_rituals.iced_brew.*.ritual' => 'nullable|string|max:255',
            'brewing_rituals.iced_brew.*.image' => 'nullable',
            'status' => 'nullable|boolean',
            'variants' => 'nullable|array',
            'variants.*.id' => [
                'nullable',
                'integer',
                Rule::exists('product_variants', 'id')->where(fn ($query) => $query->where('product_id', $productId)),
            ],
            'variants.*.name' => 'required_with:variants|string|max:255',
            'variants.*.sku' => 'required_with:variants|string|max:100|distinct',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
            'variants.*.discount_price' => 'nullable|numeric|min:0',
            'variants.*.weight' => 'nullable|string|max:255',
            'variants.*.is_default' => 'nullable|boolean',
            'variants.*.status' => 'nullable|boolean',
        ];
    }
}
