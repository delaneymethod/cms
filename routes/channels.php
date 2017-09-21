<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\User;
use App\Models\Order;

Broadcast::channel('users.{id}', function (User $user, int $id) {
	return $user->id === $id;
});

Broadcast::channel('orders.{id}', function (User $user, int $id) {
	return $user->id === Order::find($id)->user_id;
});
