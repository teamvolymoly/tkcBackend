<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductIngredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductIngredientController extends Controller
{
    public function store(Request $request, $id)
    {
        Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'value' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $ingredient = ProductIngredient::create([
            'product_id' => $id,
            'name' => $request->name,
            'value' => $request->value,
            'sort_order' => $request->integer('sort_order', 0),
        ]);

        return response()->json(['status' => true, 'message' => 'Ingredient added', 'data' => $ingredient], 201);
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
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $ingredient->update([
            'name' => $request->name,
            'value' => $request->value,
            'sort_order' => $request->integer('sort_order', 0),
        ]);

        return response()->json(['status' => true, 'message' => 'Ingredient updated', 'data' => $ingredient->fresh()]);
    }

    public function destroy($id)
    {
        $ingredient = ProductIngredient::findOrFail($id);
        $ingredient->delete();

        return response()->json(['status' => true, 'message' => 'Ingredient deleted']);
    }
}
