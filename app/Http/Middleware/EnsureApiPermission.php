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
                'message' => 'Authentication is required to access this resource. Please log in and try again.',
            ], 401);
        }

        if ($user->hasRole('admin') || $user->can($permission)) {
            return $next($request);
        }

        return new JsonResponse([
            'status' => false,
            'message' => 'You do not have permission to perform this action.',
        ], 403);
    }
}
