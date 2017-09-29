<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Policies;

use App\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view, create, update or delete the resource.
	 *
	 * @param	User		$currentUser
	 * @param	Order		$order
	 * @return mixed
	 */
	public function userOwnsThis(User $currentUser, Order $order) : bool
	{
		// If the current user is a super admin, who can do everything, just return true.
		if ($currentUser->isSuperAdmin()) {
			return true;
		}
		
		/**
		 * So if the current user is not a super admin or themselves, we then do:
		 *
		 * 1) Grab all the current users orders. 
		 * 2) For all orders, loop over all of them until we find a match, if any.
		 *
		 * If the order id matches any orders is in current users orders list, we're good to go.
		 *
		 * Otherwise, the order does not belong to any to the current users orders and the current
		 * user cannot manage the order in question and a 403 forbiddon is thrown.
		 */
		return $currentUser->orders->pluck('id')->contains($order->id);
	}
}
