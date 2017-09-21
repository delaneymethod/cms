<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

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
