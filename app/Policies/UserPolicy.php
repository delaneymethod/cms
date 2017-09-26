<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view, create, update or delete the resource.
	 *
	 * @param	User	$currentUser
	 * @param	User	$user
	 * @return mixed
	 */
	public function userOwnsThis(User $currentUser, User $user) : bool
	{
		// If the current user is a super admin, who can do everything, just return true.
		if ($currentUser->isSuperAdmin()) {
			return true;
		}
	
		// If the current user id and the user id in question match it means that the user in question is the current user - basically its themselves.
		if ($currentUser->id == $user->id) {
			return true;
		}
	
		/**
		 * So if the current user is not a super admin or themselves, we then do:
		 *
		 * 1) Grab all the current users companies users. 
		 * 2) For all company users, loop over all of them until we find a match, if any.
		 *
		 * If the user id matches any user is in current users companies users list, we're good to go.
		 *
		 * Otherwise, the user does not belong to any to the current users companies users and the current
		 * user cannot manage the user in question and a 403 forbiddon is thrown.
		 */
		return $currentUser->company->users->pluck('id')->contains($user->id);
	}
}
