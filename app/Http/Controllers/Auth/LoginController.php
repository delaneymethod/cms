<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Controllers\Auth;

use Cart;
use Illuminate\Http\Request;
use App\Events\UserLoginEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\{Auth, Session};
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Traits\{CartTrait, PasswordResetTrait};

class LoginController extends Controller
{
	use CartTrait, PasswordResetTrait, AuthenticatesUsers;

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
			Auth::logout();

			flash('Your account is pending! Please contact your account owner.', $level = 'warning');

			return back();
		}
		
		// Check if the user status is retired
		if ($user->status->id === 3) {
			Auth::logout();

			flash('Your account has been retired! Please contact your account owner.', $level = 'warning');

			return back();
		}

		// If the user has logged in successfully, and they have password reset requests pending, just remove them.
		$passwordResets = $this->getPasswordReset($user->email);

		if (count($passwordResets) > 0) {
			$this->deletePasswordReset($user->email);
		}
		
		// Used to update the frontend / backend UI's
		UserLoginEvent::dispatch($user);
		
		// If we are redirecting user back to previous page, then we set the new route here
		$redirectTo = $request->get('redirectTo');
		
		if (!empty($redirectTo)) {
			$this->redirectTo = $redirectTo;	
		}
		
		return redirect($this->redirectTo);
	}
	
	/**
	 * Override logout method in \Illuminate\Foundation\Auth\AuthenticatesUsers.php
	 *
	 * @param	Request 	$request
	 * @return 	mixed
	 */
	public function logout(Request $request) : RedirectResponse
	{
		$currentUser = $this->getAuthenticatedUser();
		
		// Grab cart instance. Wishlists are saved to the database by default so 'cart' will be the default cart instance in use if a user has added anything to the cart session. 
		$cart = $this->getCartInstance('cart');
		
		// Check if the cart has any items in it - if it does, store the cart otherwise we can safetly allow the cart to be destroyed without losing anything.
		if ($cart->count > 0) {
			// Create a random lowercase identifier with current users id
			$identifier = str_random(30);
			
			$identifier = strtolower($identifier);
			
			$this->storeCartInstance($identifier, $currentUser->id);
		}
		
		// Now logout and clear out all the exisiting sessions
		Auth::logout();
		
		Session::flush();
		
		Session::regenerate(true);
		
		flash('You have been logged out!', $level = 'success');
        
		return redirect($this->redirectTo);
	}
}
