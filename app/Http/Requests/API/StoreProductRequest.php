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
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'allergic_information' => 'nullable|string',
            'tea_type' => 'nullable|string|max:100',
            'disclaimer' => 'nullable|string',
            'description' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'features' => 'nullable|array',
            'status' => 'nullable|boolean',
            'variants' => 'required|array|min:1',
            'variants.*.variant_name' => 'nullable|string|max:255',
            'variants.*.size' => 'nullable|string|max:100',
            'variants.*.color' => 'nullable|string|max:100',
            'variants.*.sku' => 'required_with:variants|string|max:100|distinct|unique:product_variants,sku',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.weight' => 'nullable|numeric|min:0',
            'variants.*.dimensions' => 'nullable|string|max:255',
            'variants.*.net_weight' => 'nullable|string|max:255',
            'variants.*.tags' => 'nullable|array',
            'variants.*.brewing_rituals' => 'nullable|array',
            'variants.*.is_default' => 'nullable|boolean',
            'variants.*.status' => 'nullable|boolean',
            'variants.*.images' => 'nullable|array',
            'variants.*.images.*.file' => 'nullable|image|max:5120',
            'variants.*.images.*.is_primary' => 'nullable|boolean',
            'variants.*.images.*.sort_order' => 'nullable|integer|min:0',
        ];
    }
}
