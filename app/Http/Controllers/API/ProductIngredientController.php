<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductIngredient;
use App\Support\ProductSchema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductIngredientController extends Controller
{
    public function store(Request $request, $id)
    {
        Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'value' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $payload = [
            'product_id' => $id,
            'name' => $request->name,
            'value' => $request->value,
            'sort_order' => $request->integer('sort_order', 0),
        ];

        if (ProductSchema::hasColumn('product_ingredients', 'image_path')) {
            $payload['image_path'] = $request->file('image')?->store('products/ingredients', 'public');
        }

        $ingredient = ProductIngredient::create($payload);

        return response()->json(['status' => true, 'message' => 'Ingredient added', 'data' => $ingredient->fresh()], 201);
    }

    public function index($id)
    {
        Product::findOrFail($id);
        $ingredients = ProductIngredient::where('product_id', $id)->orderBy('sort_order')->get();

        return response()->json(['status' => true, 'data' => $ingredients]);
    }

    public function update(Request $request, $id)
    {
        $ingredient = ProductIngredient::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'value' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $payload = [
            'name' => $request->name,
            'value' => $request->value,
            'sort_order' => $request->integer('sort_order', 0),
        ];

        if (ProductSchema::hasColumn('product_ingredients', 'image_path') && $request->hasFile('image')) {
            if ($ingredient->image_path) {
                Storage::disk('public')->delete($ingredient->image_path);
            }

            $payload['image_path'] = $request->file('image')->store('products/ingredients', 'public');
        }

        $ingredient->update($payload);

        return response()->json(['status' => true, 'message' => 'Ingredient updated', 'data' => $ingredient->fresh()]);
    }

    public function destroy($id)
    {
        $ingredient = ProductIngredient::findOrFail($id);

        if (ProductSchema::hasColumn('product_ingredients', 'image_path') && $ingredient->image_path) {
            Storage::disk('public')->delete($ingredient->image_path);
        }

        $ingredient->delete();

        return response()->json(['status' => true, 'message' => 'Ingredient deleted']);
    }
}
