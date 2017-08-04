<?php

namespace App\Http\Traits;

use App\User;
use Illuminate\Support\Facades\Auth;

trait UserTrait
{
	/**
	 * Get the specified user based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getUser(int $id)
	{
		$user = User::findOrFail($id);
		
		$currentUser = $this->getAuthenticatedUser();
		
		// No need to filter if the user we're editing is the current user.
		if ($currentUser->id == $user->id) {
			return $user;
		}
		
		return $this->filterUsers([$user])->first();
	}
	
	/**
	 * Get all the users.
	 *
	 * @return 	Collection
	 */
	public function getUsers()
	{
		$users = $this->filterUsers(User::all());
		
		$limit = $this->getLimit();

		return $this->paginateCollection($users, $limit);
	}
	
	/**
	 * Get the user record by their id - mainly used for user activation since we dont want to filter the users array in getUser above..
	 */
	public function getUserById(int $id)
	{
		return User::where('id', $id)->first();
	}

	/**
	 * Get the user record by their email.
	 */
	public function getUserByEmail(string $email)
	{
		return User::where('email', $email)->first();
	}
	
	/**
	 * Get the super admin user records
	 *
	 * @return 	Response
	 */
	public function getSuperAdmins()
	{
		return User::where('role_id', 1);
	}
	
	/**
	 * Get the admin user records
	 *
	 * @return 	Response
	 */
	public function getAdmins()
	{
		return User::where('role_id', 2);
	}
	
	/**
	 * Get the user record by their email off the User Model.
	 */
	public static function getByEmail(string $email)
	{
		return self::where('email', $email)->first();
	}
}
