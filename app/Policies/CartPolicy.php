<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Policies;

use App\User;
use App\Models\Cart;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view, create, update or delete the resource.
	 *
	 * @param	User		$currentUser
	 * @param	Cart		$cart
	 * @return mixed
	 */
	public function userOwnsThis(User $currentUser, Cart $cart) : bool
	{
		// If the current user is a super admin, who can do everything, just return true.
		if ($currentUser->isSuperAdmin()) {
			return true;
		}
		
		/**
		 * So if the current user is not a super admin or themselves, we then do:
		 *
		 * 1) Grab all the current users carts. 
		 * 2) For all carts, loop over all of them until we find a match, if any.
		 *
		 * If the cart id matches any carts is in current users carts list, we're good to go.
		 *
		 * Otherwise, the cart does not belong to any to the current users carts and the current
		 * user cannot manage the cart in question and a 403 forbiddon is thrown.
		 */
		return $currentUser->carts->pluck('identifier')->contains($cart->identifier);
	}
}
