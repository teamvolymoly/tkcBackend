<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsletterSubscriberController extends Controller
{
    public function index(Request $request): View
    {
        $subscribers = NewsletterSubscriber::query()
            ->when($request->filled('q'), fn ($query) => $query->where('email', 'like', '%'.trim((string) $request->q).'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest('subscribed_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.newsletter-subscribers.index', [
            'subscribers' => $subscribers,
            'totalSubscribers' => NewsletterSubscriber::count(),
            'activeSubscribers' => NewsletterSubscriber::where('status', 'active')->count(),
        ]);
    }

    public function destroy(NewsletterSubscriber $newsletterSubscriber): RedirectResponse
    {
        $newsletterSubscriber->delete();

        return redirect()
            ->route('admin.newsletter-subscribers.index')
            ->with('success', 'Newsletter subscriber deleted successfully.');
    }
}
