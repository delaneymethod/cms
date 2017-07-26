<?php

namespace App\Policies;

use App\User;
use App\Models\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view, create, update or delete the resource.
	 *
	 * @param	User		$currentUser
	 * @param	Company		$company
	 * @return mixed
	 */
	public function userOwnsThis(User $currentUser, Company $company)
	{
		// If the current user is a super admin, who can do everything, just return true.
		if ($currentUser->isSuperAdmin()) {
			return true;
		}
	
		return $currentUser->company_id == $company->id;
	}
}
