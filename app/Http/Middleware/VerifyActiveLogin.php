<?php

namespace App\Http\Middleware;

use Closure;

class VerifyActiveLogin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        $user = auth($guard)->user();
        if ($user->suspendedByAdmin) {
            auth($guard)->logout();
            return response(view('frontend.errors.503', ['error' => __('Admin deactivated your account')]));
        }
        return $next($request);
    }

}
