<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductVariantController extends Controller
{
    public function index($id)
    {
        $variants = ProductVariant::with('product')
            ->where('product_id', $id)
            ->where('status', true)
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        return response()->json(['status' => true, 'data' => $variants]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:product_variants,sku',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'weight' => 'nullable|string|max:255',
            'brewing_rituals' => 'nullable|array',
            'is_default' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $payload = [
            'product_id' => $request->product_id,
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'weight' => $request->weight,
            'brewing_rituals' => $request->brewing_rituals,
            'is_default' => false,
            'status' => $request->boolean('status', true),
        ];

        $variant = ProductVariant::create($payload);

        if ($request->boolean('is_default')) {
            ProductVariant::where('product_id', $variant->product_id)->update(['is_default' => false]);
            $variant->update(['is_default' => true]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Variant created',
            'data' => $variant->fresh()->load('product'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'sku' => 'sometimes|required|string|max:100|unique:product_variants,sku,'.$variant->id,
            'price' => 'sometimes|required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'weight' => 'nullable|string|max:255',
            'brewing_rituals' => 'nullable|array',
            'is_default' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $payload = $request->only(['name', 'sku', 'price', 'discount_price', 'weight', 'brewing_rituals', 'status']);

        $variant->update($payload);

        if ($request->has('is_default') && $request->boolean('is_default')) {
            ProductVariant::where('product_id', $variant->product_id)->update(['is_default' => false]);
            $variant->update(['is_default' => true]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Variant updated',
            'data' => $variant->fresh()->load('product'),
        ]);
    }

    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();

        return response()->json(['status' => true, 'message' => 'Variant deleted']);
    }
}
