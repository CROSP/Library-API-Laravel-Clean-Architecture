<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], ResponseAlias::HTTP_UNAUTHORIZED);
        }
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden, insufficient role'], ResponseAlias::HTTP_FORBIDDEN);
    }
}
