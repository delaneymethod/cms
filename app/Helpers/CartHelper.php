<?php
/**
 * @link	  https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license	  https://www.delaneymethod.com/cms/license
 */
 
namespace App\Helpers;

use Cart;
use Event;
	
class CartHelper extends Cart
{	
	/**
	 * Store an the current instance of the cart.
	 *
	 * @param 	string 	$identifier
	 * @param 	int 	$userId
	 * @return 	void
	 */
	public function store(string $identifier, int $userId)
	{
		$content = Cart::getContent();
		 
		if (Cart::storedCartWithIdentifierExists($identifier)) {
			throw new CartAlreadyStoredException("A cart with identifier {$identifier} was already stored.");
		}

		Cart::getConnection()->table(Cart::getTableName())->insert([
			'identifier' => $identifier,
			'instance' => Cart::currentInstance(),
			'user_id' => $userId,
			'content' => serialize($content),
		]);

		Event::fire('cart.stored');
	}
}
	