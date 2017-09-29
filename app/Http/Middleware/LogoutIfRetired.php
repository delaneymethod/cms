<?php
/**
 * @link	  https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license	  https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LogoutIfRetired
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  Request			$request
	 * @param  Closure			$next
	 * @param  string|null		$guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		if (Auth::guard($guard)->check() && Auth::user()->isRetired()) {
			Auth::logout();
			
			flash('Your account has been retired! Please contact your account owner.', $level = 'warning');

			return redirect('/login');
		}
		
		return $next($request);
	}
}
