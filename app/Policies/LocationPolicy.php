<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Policies;

use App\User;
use App\Models\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view, create, update or delete the resource.
	 *
	 * @param	User		$currentUser
	 * @param	Location	$location
	 * @return mixed
	 */
	public function userOwnsThis(User $currentUser, Location $location) : bool
	{
		// If the current user is a super admin, who can do everything, just return true.
		if ($currentUser->isSuperAdmin()) {
			return true;
		}
		
		/**
		 * So if the current user is not a super admin or themselves, we then do:
		 *
		 * 1) Grab all the current users companies locations. 
		 * 2) For all company locations, loop over all of them until we find a match, if any.
		 *
		 * If the location id matches any location is in current users companies locations list, we're good to go.
		 *
		 * Otherwise, the location does not belong to any to the current users companies locations and the current
		 * user cannot manage the location in question and a 403 forbiddon is thrown.
		 */
		if ($currentUser->company->locations->pluck('id')->contains($location->id)) {
			return true;
		}
		
		return false;
	}
}
