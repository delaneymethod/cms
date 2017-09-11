<?php

namespace App\Http\Traits;

use App\Models\PasswordReset;

trait PasswordResetTrait
{
	/**
	 * Get the specified password reset record based on email.
	 *
	 * @param 	string 		$email
	 * @return 	Object
	 */
	public function getPasswordReset(string $email) : PasswordReset
	{
		return PasswordReset::where('email', $email)->first();
	}

	/**
	 * Delete the password reset record by the email as we dont have a PK for this schema.
	 *
	 * @param 	string 		$email
	 * @return 	Object
	 */
	public function deletePasswordReset(string $email) : PasswordReset
	{
		return PasswordReset::where('email', $email)->delete();
	}
}
