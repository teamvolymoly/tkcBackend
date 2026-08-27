<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class NewsletterSubscriberController extends Controller
{
    public function store(Request $request)
    {
        $request->merge([
            'email' => Str::lower(trim((string) $request->input('email'))),
        ]);

        try {
            $validated = $request->validate([
                'email' => ['required', 'email:rfc', 'max:255'],
            ], [
                'email.required' => 'Please enter your email address.',
                'email.email' => 'Please enter a valid email address.',
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'message' => collect($exception->errors())->flatten()->first(),
                'errors' => $exception->errors(),
            ], 422);
        }

        $subscriber = NewsletterSubscriber::where('email', $validated['email'])->first();

        if ($subscriber?->status === 'active') {
            return response()->json([
                'status' => true,
                'message' => 'You are already subscribed!',
                'data' => ['subscriber' => $subscriber],
            ]);
        }

        $subscriber = NewsletterSubscriber::updateOrCreate(
            ['email' => $validated['email']],
            ['status' => 'active', 'subscribed_at' => now()],
        );

        return response()->json([
            'status' => true,
            'message' => 'Thanks for Subscribing!',
            'data' => ['subscriber' => $subscriber],
        ], 201);
    }

    public function adminIndex(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['active', 'unsubscribed'])],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $subscribers = NewsletterSubscriber::query()
            ->when($validated['search'] ?? null, fn ($query, $search) => $query->where('email', 'like', '%'.$search.'%'))
            ->when($validated['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->latest('subscribed_at')
            ->paginate($validated['per_page'] ?? 20)
            ->withQueryString();

        return response()->json([
            'status' => true,
            'message' => 'Newsletter subscribers fetched successfully',
            'data' => $subscribers,
        ]);
    }

    public function adminShow(NewsletterSubscriber $newsletterSubscriber)
    {
        return response()->json([
            'status' => true,
            'data' => ['subscriber' => $newsletterSubscriber],
        ]);
    }

    public function adminDestroy(NewsletterSubscriber $newsletterSubscriber)
    {
        $newsletterSubscriber->delete();

        return response()->json([
            'status' => true,
            'message' => 'Newsletter subscriber deleted successfully',
        ]);
    }
}
