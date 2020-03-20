<?php

namespace App\Http\Middleware;

use Closure;

class CheckCors
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
        ->header('Access-Control-Allow-Origin','*')
        ->header('Access-Control-Allow' ,'GET, POST, PATCH, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers','Content-Type, Authorization');
    }
}