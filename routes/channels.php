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

// Current user
Broadcast::channel('users.{id}', function (User $user, int $id) {
	return $user->id === $id;
});

// Current users > company > orders
Broadcast::channel('orders.{id}', function (User $user, int $id) {
	if ($user->isSuperAdmin()) {
		return true;
	} else {
		return $user->id === Order::find($id)->user_id;
	}
});

Broadcast::channel('locations.{id}', function (User $user, int $id) {
	return true;
});

Broadcast::channel('products.{id}', function (User $user, int $id) {
	return true;
});

Broadcast::channel('product_vat_rates.{id}', function (User $user, int $id) {
	return true;
});

Broadcast::channel('product_standards.{id}', function (User $user, int $id) {
	return true;
});

Broadcast::channel('product_categories.{id}', function (User $user, int $id) {
	return true;
});

Broadcast::channel('product_attributes.{id}', function (User $user, int $id) {
	return true;
});

Broadcast::channel('product_commodities.{id}', function (User $user, int $id) {
	return true;
});

Broadcast::channel('product_manufacturers.{id}', function (User $user, int $id) {
	return true;
});

Broadcast::channel('product_characteristics.{id}', function (User $user, int $id) {
	return true;
});

Broadcast::channel('product_standard_organisations.{id}', function (User $user, int $id) {
	return true;
});
