<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Traits\PasswordResetTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
	use PasswordResetTrait, AuthenticatesUsers;

	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}
	
	/**
	 * Override register method in \Illuminate\Foundation\Auth\AuthenticatesUsers.php
	 *
	 * @param	Request 	$request
	 * @param 	mixed 		$user
	 * @return 	mixed
	 */
	protected function authenticated(Request $request, $user) : RedirectResponse
	{
		// Check if the user status is pending
		if ($user->status->id === 2) {
			auth()->logout();

			flash('Your account is pending! Please contact your account owner.', $level = 'warning');

			return back();
		}
		
		// Check if the user status is retired
		if ($user->status->id === 3) {
			auth()->logout();

			flash('Your account has been retired! Please contact your account owner.', $level = 'warning');

			return back();
		}

		// If the user has logged in successfully, and they have password reset requests pending, just remove them.
		$passwordResets = $this->getPasswordReset($user->email);

		if (count($passwordResets) > 0) {
			$this->deletePasswordReset($user->email);
		}
		
		// https://github.com/tutsplus/build-a-cms-with-laravel/blob/master/app/Listeners/UpdateLastLoginOnLogin.php
		
		// If we are redirecting user back to previous page, then we set the new route here
		$redirectTo = $request->get('redirectTo');
		
		if (!empty($redirectTo)) {
			$this->redirectTo = $redirectTo;	
		}
		
		return redirect($this->redirectTo);
	}
}
