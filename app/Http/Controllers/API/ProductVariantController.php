<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Support\ProductSchema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductVariantController extends Controller
{
    public function index($id)
    {
        $variants = ProductVariant::with(['inventory', 'primaryImage', 'images'])
            ->where('product_id', $id)
            ->where('status', true)
            ->latest()
            ->get();

        return response()->json(['status' => true, 'data' => $variants]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'variant_name' => 'required|string|max:255',
            'size' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:100',
            'sku' => 'required|string|max:100|unique:product_variants,sku',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'net_weight' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'brewing_rituals' => 'nullable|array',
            'is_default' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $payload = [
            'product_id' => $request->product_id,
            'variant_name' => $request->variant_name,
            'size' => $request->size,
            'color' => $request->color,
            'sku' => $request->sku,
            'price' => $request->price,
            'stock' => $request->integer('stock', 0),
            'weight' => $request->weight,
            'dimensions' => $request->dimensions,
            'net_weight' => $request->net_weight,
            'tags' => $request->tags,
            'brewing_rituals' => $request->brewing_rituals,
            'status' => $request->boolean('status', true),
        ];

        if (ProductSchema::hasColumn('product_variants', 'compare_price')) {
            $payload['compare_price'] = $request->compare_price;
        }

        if (ProductSchema::hasColumn('product_variants', 'is_default')) {
            $payload['is_default'] = false;
        }

        $variant = ProductVariant::create($payload);

        if (ProductSchema::hasColumn('product_variants', 'is_default') && $request->boolean('is_default')) {
            ProductVariant::where('product_id', $variant->product_id)->update(['is_default' => false]);
            $variant->update(['is_default' => true]);
        }

        $variant->inventory()->create([
            'stock' => $variant->stock,
            'reserved_stock' => 0,
            'warehouse' => 'default',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Variant created',
            'data' => $variant->fresh()->load(['inventory', 'primaryImage', 'images']),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'variant_name' => 'sometimes|required|string|max:255',
            'size' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:100',
            'sku' => 'sometimes|required|string|max:100|unique:product_variants,sku,'.$variant->id,
            'price' => 'sometimes|required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'net_weight' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'brewing_rituals' => 'nullable|array',
            'is_default' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $payload = $request->only(['variant_name', 'size', 'color', 'sku', 'price', 'stock', 'weight', 'dimensions', 'net_weight', 'tags', 'brewing_rituals', 'status']);

        if (ProductSchema::hasColumn('product_variants', 'compare_price')) {
            $payload['compare_price'] = $request->compare_price;
        }

        $variant->update($payload);

        if (ProductSchema::hasColumn('product_variants', 'is_default') && $request->has('is_default') && $request->boolean('is_default')) {
            ProductVariant::where('product_id', $variant->product_id)->update(['is_default' => false]);
            $variant->update(['is_default' => true]);
        }

        if ($request->has('stock') && $variant->inventory) {
            $variant->inventory->update(['stock' => $request->stock]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Variant updated',
            'data' => $variant->fresh()->load(['inventory', 'primaryImage', 'images']),
        ]);
    }

    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();

        return response()->json(['status' => true, 'message' => 'Variant deleted']);
    }
}
