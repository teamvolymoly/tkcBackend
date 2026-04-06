<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApiPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user) {
            return new JsonResponse([
                'status' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if ($user->hasRole('admin') || $user->can($permission)) {
            return $next($request);
        }

        return new JsonResponse([
            'status' => false,
            'message' => 'User does not have the right permissions.',
        ], 403);
    }
}
