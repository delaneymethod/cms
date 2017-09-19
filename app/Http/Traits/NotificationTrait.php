<?php

namespace App\Http\Traits;

use App\Models\Notification;

trait NotificationTrait
{
	/**
	 * Get the specified county based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getNotification(string $uuid) : Notification
	{
		return Notification::findOrFail($uuid);
	}
}
