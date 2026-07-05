<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends BaseAdminController
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'rating', 'status', 'page']);

        return view('admin.reviews.index', [
            'reviews' => $this->apiService->get('admin/reviews', array_filter($filters, fn ($value) => $value !== null && $value !== ''))['data'] ?? [],
            'filters' => $filters,
        ]);
    }

    public function show(int $review): View
    {
        $response = $this->apiService->get("admin/reviews/{$review}");
        abort_unless($response['ok'], 404);

        return view('admin.reviews.show', ['review' => $response['data']]);
    }

    public function updateStatus(Request $request, int $review): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
        ]);

        $response = $this->apiService->put("admin/reviews/{$review}/status", $validated);

        if (! $response['ok']) {
            return back()->with('error', $response['message'] ?: 'Unable to update review status.');
        }

        return back()->with('success', $response['message'] ?: 'Review status updated successfully.');
    }

    public function destroy(int $review): RedirectResponse
    {
        $response = $this->apiService->delete("admin/reviews/{$review}");

        if (! $response['ok']) {
            return back()->with('error', $response['message'] ?: 'Unable to delete review.');
        }

        return redirect()->route('admin.reviews.index')->with('success', $response['message'] ?: 'Review deleted successfully.');
    }
}
