<?php

namespace App\Http\Middleware;

use App\Services\AdminApiService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminSession
{
    public function __construct(private readonly AdminApiService $apiService)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->session()->get('admin_token');

        if (! $token) {
            return redirect()->route('admin.login');
        }

        $cachedAdmin = $request->session()->get('admin_user');
        $checkedAt = (int) $request->session()->get('admin_profile_checked_at', 0);

        if ($cachedAdmin && (time() - $checkedAt) < 300) {
            view()->share('adminUser', $cachedAdmin);

            return $next($request);
        }

        $response = $this->apiService->profile($token);

        if (! $response['ok']) {
            $request->session()->forget(['admin_token', 'admin_user', 'admin_profile_checked_at']);

            return redirect()->route('admin.login')->withErrors([
                'email' => $response['message'] ?: 'Your admin session has expired. Please sign in again.',
            ]);
        }

        $user = $response['data'];
        $roles = collect($user['roles'] ?? [])->pluck('name');

        if (! $roles->contains('admin')) {
            $request->session()->forget(['admin_token', 'admin_user', 'admin_profile_checked_at']);

            return redirect()->route('admin.login')->withErrors([
                'email' => 'This account does not have admin access.',
            ]);
        }

        $request->session()->put('admin_user', $user);
        $request->session()->put('admin_profile_checked_at', time());
        view()->share('adminUser', $user);

        return $next($request);
    }
}
