<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreProductRequest;
use App\Http\Requests\API\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    public function index(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Products fetched successfully',
            'data' => $this->productService->paginatedCatalog($request->only(['category_id', 'q', 'status'])),
        ]);
    }

    public function show($slug)
    {
        return response()->json([
            'status' => true,
            'message' => 'Product fetched successfully',
            'data' => $this->productService->publicDetailBySlug($slug),
        ]);
    }

    public function adminShow($id)
    {
        return response()->json([
            'status' => true,
            'message' => 'Product fetched successfully',
            'data' => $this->productService->adminDetailById($id),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'data' => $this->productService->create($request->validated()),
        ], 201);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => $this->productService->update($product, $request->validated()),
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->productService->delete($product);

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully',
        ]);
    }
}
