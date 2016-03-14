<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', 'http://admin.'.env('STORE_DOMAIN'))
            ->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Origin, Authorization');
    }
}
