<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect(route('dashboard.home'));
                }
                break;
            case 'company':
                if (Auth::guard($guard)->check()) {
                    return redirect(route('company.profile.show'));
                }
                break;
            case 'user':
                if (Auth::guard($guard)->check()) {
                    return redirect(route('user.profile.show'));
                }
                break;
            case null:
                if (Auth::guard('admin')->check()) {
                    return redirect(route('dashboard.home'));
                }
                if (Auth::guard('company')->check()) {
                    return redirect(route('company.profile.show'));
                }
                if (Auth::guard('user')->check()) {
                    return redirect(route('user.profile.show'));
                }
                break;
            default:
                break;
        }

        return $next($request);
    }

}
