<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class HeroSectionController extends Controller
{
    public function index(Request $request)
    {
        $isAdmin = $request->user()?->canAccessAdminPanel() ?? false;

        $heroSections = HeroSection::query()
            ->when(! $isAdmin, fn ($query) => $query->where('status', true))
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->string('q')->trim()->value();
                $query->where(function ($inner) use ($term) {
                    $inner->where('product_name', 'like', "%{$term}%")
                        ->orWhere('product_slug', 'like', "%{$term}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->boolean('status')))
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate($isAdmin ? 20 : 10)
            ->withQueryString();

        return response()->json([
            'status' => true,
            'message' => 'Hero sections fetched successfully',
            'data' => $heroSections,
        ]);
    }

    public function show(Request $request, HeroSection $heroSection)
    {
        $isAdmin = $request->user()?->canAccessAdminPanel() ?? false;

        if (! $isAdmin && ! $heroSection->status) {
            abort(404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Hero section fetched successfully',
            'data' => $heroSection,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $heroSection = HeroSection::create([
            'product_image_path' => $request->hasFile('product_image') ? $request->file('product_image')->store('hero-sections', 'public') : null,
            'product_name' => $validated['product_name'],
            'product_slug' => $this->uniqueSlug($validated['product_slug'] ?? $validated['product_name']),
            'status' => $request->boolean('status', true),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Hero section created successfully',
            'data' => $heroSection,
        ], 201);
    }

    public function update(Request $request, HeroSection $heroSection)
    {
        $validated = $this->validated($request, $heroSection);
        $imagePath = $heroSection->product_image_path;

        if ($request->hasFile('product_image')) {
            if ($imagePath && ! Str::startsWith($imagePath, ['http://', 'https://'])) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $request->file('product_image')->store('hero-sections', 'public');
        }

        $heroSection->update([
            'product_image_path' => $imagePath,
            'product_name' => $validated['product_name'],
            'product_slug' => $this->uniqueSlug($validated['product_slug'] ?? $validated['product_name'], $heroSection->id),
            'status' => $request->boolean('status'),
            'sort_order' => (int) ($validated['sort_order'] ?? $heroSection->sort_order),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Hero section updated successfully',
            'data' => $heroSection->fresh(),
        ]);
    }

    public function destroy(HeroSection $heroSection)
    {
        if ($heroSection->product_image_path && ! Str::startsWith($heroSection->product_image_path, ['http://', 'https://'])) {
            Storage::disk('public')->delete($heroSection->product_image_path);
        }

        $heroSection->delete();

        return response()->json([
            'status' => true,
            'message' => 'Hero section deleted successfully',
        ]);
    }

    private function validated(Request $request, ?HeroSection $heroSection = null): array
    {
        return $request->validate([
            'product_image' => ['nullable', 'image', 'max:5120'],
            'product_name' => ['required', 'string', 'max:255'],
            'product_slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('hero_sections', 'product_slug')->ignore($heroSection?->id),
            ],
            'status' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value);
        $slug = $base !== '' ? $base : 'hero-item';
        $original = $slug;
        $counter = 1;

        while (HeroSection::query()
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->where('product_slug', $slug)
            ->exists()) {
            $slug = $original.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
