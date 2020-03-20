<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->getHttpHost() === config('app.dashboard_subdomain') . '.' . config('app.domain')) {
                return route('dashboard.login');
            }
            if (substr($request->getRequestUri(), 0, 8) === '/company') {
                return route('company.login');
            }
            return route('user.login');
        }
    }
}
