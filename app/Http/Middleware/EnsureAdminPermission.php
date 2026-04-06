<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $adminUser = $request->session()->get('admin_user', []);
        $roles = collect($adminUser['roles'] ?? [])->pluck('name');
        $permissions = collect($adminUser['permissions'] ?? [])->pluck('name');

        if ($roles->contains('admin') || $permissions->contains($permission)) {
            return $next($request);
        }

        return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access that admin section.');
    }
}
