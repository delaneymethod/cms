<?php

namespace App\Http\Middleware;

use Route;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  		$request
     * @param  Closure  		$next
     * @param  string|null  	$guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
	    if (Auth::guard($guard)->check() && in_array(Route::current()->uri(), ['register', 'login'])) {
            return redirect('/dashboard');
        }
        
        return $next($request);
    }
}
