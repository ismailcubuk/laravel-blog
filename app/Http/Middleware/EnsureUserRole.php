<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403);
        }

        $directRole = strtolower((string) $user->role) === strtolower($role);
        $relationalRole = method_exists($user, 'roles')
            && $user->roles()->whereRaw('LOWER(name) = ?', [strtolower($role)])->exists();

        if (!$directRole && !$relationalRole) {
            abort(403);
        }

        return $next($request);
    }
}
