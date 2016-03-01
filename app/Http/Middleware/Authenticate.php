<?php

namespace App\Http\Middleware;

use Closure;

use JWTAuth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $roll = 'user')
    {
        // Check if logged in
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json('User is unauthorized.', 401);
        }

        if ($roll == 'admin') {
            if (!$user->admin && !$user->root) {
                return response()->json('User is forbidden.', 403);
            }
        } else if ($roll == 'catalogs') {
            if (!$user->admin && !$user->root && !$user->catalogs) {
                return response()->json('User is forbidden.', 403);
            }
        } else if ($roll == 'customers') {
            if (!$user->admin && !$user->root && !$user->customers) {
                return response()->json('User is forbidden.', 403);
            }
        } else if ($roll == 'inventory') {
            if (!$user->admin && !$user->root && !$user->inventory) {
                return response()->json('User is forbidden.', 403);
            }
        } else if ($roll == 'invoices') {
            if (!$user->admin && !$user->root && !$user->invoices) {
                return response()->json('User is forbidden.', 403);
            }
        } else if ($roll == 'pages') {
            if (!$user->admin && !$user->root && !$user->pages) {
                return response()->json('User is forbidden.', 403);
            }
        }

        return $next($request);
    }
}
