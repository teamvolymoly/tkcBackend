<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\ProductVariantImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductVariantImageController extends Controller
{
    public function index($id)
    {
        $variant = ProductVariant::findOrFail($id);
        $images = $variant->images()->get();

        return response()->json(['status' => true, 'data' => $images]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'variant_id' => ['required', 'exists:product_variants,id'],
            'image' => ['required', 'file', 'image', 'max:5120'],
            'is_primary' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $image = DB::transaction(function () use ($request, $validated) {
            $variant = ProductVariant::findOrFail($validated['variant_id']);
            $image = $variant->images()->create([
                'image_path' => $request->file('image')->store('products/variants', 'public'),
                'is_primary' => false,
                'sort_order' => $validated['sort_order'] ?? (($variant->images()->max('sort_order') ?? -1) + 1),
            ]);

            $this->syncPrimaryImage($variant, $image, (bool) ($validated['is_primary'] ?? false));

            return $image->fresh();
        });

        return response()->json(['status' => true, 'message' => 'Variant image added successfully', 'data' => $image], 201);
    }

    public function update(Request $request, $id)
    {
        $image = ProductVariantImage::findOrFail($id);

        $validated = $request->validate([
            'image' => ['nullable', 'file', 'image', 'max:5120'],
            'is_primary' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $updatedImage = DB::transaction(function () use ($request, $validated, $image) {
            if ($request->hasFile('image')) {
                if ($image->image_path) {
                    Storage::disk('public')->delete($image->image_path);
                }

                $image->image_path = $request->file('image')->store('products/variants', 'public');
            }

            if (array_key_exists('sort_order', $validated)) {
                $image->sort_order = $validated['sort_order'];
            }

            $image->save();

            $this->syncPrimaryImage($image->variant, $image, (bool) ($validated['is_primary'] ?? false));

            return $image->fresh();
        });

        return response()->json(['status' => true, 'message' => 'Variant image updated successfully', 'data' => $updatedImage]);
    }

    public function destroy($id)
    {
        $image = ProductVariantImage::findOrFail($id);

        DB::transaction(function () use ($image) {
            $variant = $image->variant;

            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
            }

            $wasPrimary = $image->is_primary;
            $image->delete();

            if ($wasPrimary && $variant) {
                $replacement = $variant->images()->orderBy('sort_order')->orderBy('id')->first();

                if ($replacement) {
                    $variant->images()->update(['is_primary' => false]);
                    $variant->images()->whereKey($replacement->id)->update(['is_primary' => true]);
                }
            }
        });

        return response()->json(['status' => true, 'message' => 'Variant image deleted successfully']);
    }

    private function syncPrimaryImage(ProductVariant $variant, ProductVariantImage $image, bool $shouldBePrimary): void
    {
        if ($shouldBePrimary || ! $variant->images()->where('is_primary', true)->exists()) {
            $variant->images()->update(['is_primary' => false]);
            $variant->images()->whereKey($image->id)->update(['is_primary' => true]);
        }
    }
}
