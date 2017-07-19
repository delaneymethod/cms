<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\PasswordResetTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
	use PasswordResetTrait;
	use AuthenticatesUsers;

	protected $redirectTo = '/dashboard';

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
	 * @param	\Illuminate\Http\Request  $request
	 * @param  mixed  $user
	 * @return mixed
	 */
	protected function authenticated(Request $request, $user)
	{
		// Check if the user status is closed
		if ($user->status->id === 2) {
			auth()->logout();

			flash('Your account has been closed! Please contact your account owner.', $level = 'warning');

			return back();
		}

		// If the user has logged in successfully, and they have password reset requests pending, just remove them.
		$passwordResets = $this->getPasswordReset($user->email);

		if (count($passwordResets) > 0) {
			$this->deletePasswordReset($user->email);
		}
		
		return redirect('/dashboard');
	}
}
