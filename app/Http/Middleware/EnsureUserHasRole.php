<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    /**
     * Allow the request only when the authenticated user has one of the given roles.
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();

        if ($user === null) {
            return redirect()->route('login');
        }

        abort_unless($user->hasRole($roles), 403);

        return $next($request);
    }
}
