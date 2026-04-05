<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $showInactive = $request->boolean('include_inactive') && $request->user()?->hasRole('admin');
        $query = Category::query()->whereNull('parent_id');

        if ($showInactive) {
            $query->with('children');
        } else {
            $query->where('status', 1);
            $query->with(['children' => fn ($childQuery) => $childQuery->where('status', 1)]);
        }

        $categories = $query->get();

        return response()->json([
            'status' => true,
            'data' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|boolean',
        ]);

        $slug = $this->generateUniqueSlug($request->name);

        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'image_path' => $request->hasFile('image') ? $request->file('image')->store('categories', 'public') : null,
            'parent_id' => $request->parent_id,
            'status' => $request->boolean('status', true),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }

    public function show(Category $category)
    {
        $isAdmin = optional(request()->user())->hasRole('admin');

        if ($category->status !== 1 && ! $isAdmin) {
            abort(404);
        }

        $category->load([
            'children' => function ($query) use ($isAdmin) {
                if (! $isAdmin) {
                    $query->where('status', 1);
                }
            },
        ]);

        return response()->json([
            'status' => true,
            'data' => $category,
        ]);
    }

    public function subcategories(Category $category)
    {
        $isAdmin = optional(request()->user())->hasRole('admin');

        if ($category->status !== 1 && ! $isAdmin) {
            abort(404);
        }

        $children = $category->children();

        if (! $isAdmin) {
            $children->where('status', 1);
        }

        return response()->json([
            'status' => true,
            'data' => $children->with([
                'children' => function ($query) use ($isAdmin) {
                    if (! $isAdmin) {
                        $query->where('status', 1);
                    }
                },
            ])->get(),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'parent_id' => [
                'nullable',
                Rule::exists('categories', 'id'),
                Rule::notIn([$category->id]),
            ],
            'status' => 'nullable|boolean',
        ]);

        $slug = $this->generateUniqueSlug($request->name, $category->id);
        $imagePath = $category->image_path;

        if ($request->hasFile('image')) {
            if ($imagePath && ! Str::startsWith($imagePath, ['http://', 'https://'])) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'image_path' => $imagePath,
            'parent_id' => $request->parent_id,
            'status' => $request->has('status') ? $request->boolean('status') : $category->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => $category->fresh(),
        ]);
    }

    public function destroy(Category $category)
    {
        if ($category->children()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Delete child categories first before deleting this category',
            ], 422);
        }

        if ($category->image_path && ! Str::startsWith($category->image_path, ['http://', 'https://'])) {
            Storage::disk('public')->delete($category->image_path);
        }

        $category->delete();

        return response()->json([
            'status'=>true,
            'message'=>'Category deleted successfully',
        ]);
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $suffix = 1;

        while ($this->slugExists($slug, $ignoreId)) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    private function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $query = Category::where('slug', $slug);

        if ($ignoreId !== null) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}
