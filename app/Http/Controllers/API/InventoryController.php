<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Inventory::with('variant.product')->latest()->paginate(30);

        return response()->json(['status' => true, 'data' => $inventory]);
    }

    public function update(Request $request, $variantId)
    {
        $validator = Validator::make($request->all(), [
            'stock' => 'sometimes|required|integer|min:0',
            'reserved_stock' => 'sometimes|required|integer|min:0',
            'warehouse' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $inventory = Inventory::firstOrCreate(['variant_id' => $variantId], [
            'stock' => 0,
            'reserved_stock' => 0,
            'warehouse' => 'default',
        ]);

        $inventory->update($request->only(['stock', 'reserved_stock', 'warehouse']));

        if ($request->has('stock')) {
            $inventory->variant?->update(['stock' => $request->stock]);
        }

        return response()->json(['status' => true, 'message' => 'Inventory updated', 'data' => $inventory->fresh()->load('variant')]);
    }
}
