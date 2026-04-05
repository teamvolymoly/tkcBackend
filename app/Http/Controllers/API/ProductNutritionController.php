<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductNutrition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductNutritionController extends Controller
{
    public function store(Request $request, $id)
    {
        Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nutrient' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'unit' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $nutrition = ProductNutrition::create([
            'product_id' => $id,
            'nutrient' => $request->nutrient,
            'value' => $request->value,
            'unit' => $request->unit,
        ]);

        return response()->json(['status' => true, 'message' => 'Nutrition added', 'data' => $nutrition], 201);
    }

    public function index($id)
    {
        Product::findOrFail($id);
        $nutrition = ProductNutrition::where('product_id', $id)->get();

        return response()->json(['status' => true, 'data' => $nutrition]);
    }

    public function update(Request $request, $id)
    {
        $nutrition = ProductNutrition::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nutrient' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'unit' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $nutrition->update([
            'nutrient' => $request->nutrient,
            'value' => $request->value,
            'unit' => $request->unit,
        ]);

        return response()->json(['status' => true, 'message' => 'Nutrition updated', 'data' => $nutrition->fresh()]);
    }

    public function destroy($id)
    {
        $nutrition = ProductNutrition::findOrFail($id);
        $nutrition->delete();

        return response()->json(['status' => true, 'message' => 'Nutrition deleted']);
    }
}
