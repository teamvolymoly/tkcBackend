<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:1',
        ]);

        $results = Product::with('variants')
            ->where('status', true)
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->q.'%')
                    ->orWhere('tag_line_1', 'like', '%'.$request->q.'%')
                    ->orWhere('tag_line_2', 'like', '%'.$request->q.'%')
                    ->orWhere('description', 'like', '%'.$request->q.'%');
            })
            ->latest()
            ->paginate(20);

        return response()->json(['status' => true, 'data' => $results]);
    }
}
