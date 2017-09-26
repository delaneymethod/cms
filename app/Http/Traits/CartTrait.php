<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use Cart;
use Gloudemans\Shoppingcart\CartItem;
use App\Models\{Cart as Kart, ProductCommodity};
use Illuminate\Support\Collection as SupportCollectionResponse;
use Illuminate\Database\Eloquent\Collection as EloquentCollectionResponse;

trait CartTrait
{
	/**
	 * Get the specified cart based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getCart(string $identifier) : Kart
	{
		return Kart::where('identifier', $identifier)->firstOrFail();
	}
	
	/**
	 * Get the specified cart based on identifier.
	 *
	 * @param 	string 		$identifier
	 * @return 	Object
	 */
	public function getCartByIdentifier(string $identifier) : Kart
	{
		return Kart::where('identifier', 'like', $identifier)->first();
	}
	
	/**
	 * Get carts based on identifier and instance.
	 *
	 * @param 	string 		$identifier
	 * @param 	string 		$instance
	 * @return 	Object
	 */
	public function getCartsByIdentifierInstance(string $identifier, string $instance) : EloquentCollectionResponse
	{
		return Kart::where('identifier', 'like', '%'.$identifier.'%')->where('instance', $instance)->get();
	}
	
	/**
	 * Get all the carts.
	 *
	 * @return 	Response
	 */
	public function getCarts() : EloquentCollectionResponse
	{
		return Kart::all();
	}
	
	/**
	 * Gets specific product commodity from cart instance based on row id.
	 *
	 * @param 	string			$rowId
	 * @return 	Object
	 */
	public function getCartProductCommodity(string $rowId) : CartItem
	{
		return Cart::get($rowId);
	}
	
	/**
	 * Gets product count from the cart instance
	 *
	 * @return 	int
	 */
	public function getCartCount() : int
	{
		return Cart::count();
	}
	
	/**
	 * Gets cart instance.
	 *
	 * @param 	string 		$instance
	 * @return 	Object
	 */
	public function getCartInstance(string $instance)
	{
		$this->setCartInstance($instance);
		
		return (object) [
			'product_commodities' => Cart::content(),
			'count' => Cart::count(),
			'subtotal' => Cart::subtotal(),
			'tax' => Cart::tax(),
			'total' => Cart::total(),
		];
	}
	
	/**
	 * Gets saved cart instances based on identifer.
	 *
	 * @param 	int			$userId
	 * @return 	collection
	 */
	public function getSavedCarts(int $userId) : EloquentCollectionResponse
	{
		$carts = $this->getCartsByIdentifierInstance('_'.$userId, 'cart');
		
		// Convert serialised data
		foreach ($carts as &$cart) {
			$cart->content = unserialize($cart->content);
		}
		
		return $carts;
	}
	
	/**
	 * Adds a product commodity to the cart instance.
	 *
	 * @param 	int 		$id
	 * @param 	string 		$title
	 * @param 	float 		$price
	 * @return 	Object
	 */
	public function addCartProductCommodity(int $id, string $title, float $price) : CartItem
	{
		return Cart::add($id, $title, 1, $price);
	}
	
	/**
	 * Updates a product commodities quantity in the cart instance.
	 *
	 * @param 	string 		$rowId
	 * @param 	int 		$quantity
	 * @return 	void
	 */
	public function updateCartProductCommodityQuantity(string $rowId, int $quantity)
	{
		Cart::update($rowId, $quantity);
	}
	
	/**
	 * Restores cart instance.
	 *
	 * @param 	string 		$instance
	 * @return 	void
	 */
	public function restoreCartInstance(string $identifier)
	{
		Cart::restore($identifier);
	}
	
	/**
	 * Stores cart instance.
	 *
	 * @param 	string 		$instance
	 * @return 	void
	 */
	public function storeCartInstance(string $identifier)
	{
		Cart::store($identifier);
	}
	
	/**
	 * Sets cart instance.
	 *
	 * @param 	string 		$instance
	 * @return 	void
	 */
	public function setCartInstance(string $instance)
	{
		Cart::instance($instance);
	}
	
	/**
	 * Searches cart instance for product commodity based on product id
	 *
	 * @param 	int			$id
	 * @return 	collection
	 */
	public function searchCart(int $id) : SupportCollectionResponse
	{
		return Cart::search(function ($productCommodity, $rowId) use ($id) {
			return $productCommodity->id === $id;
		});
	}
	
	/**
	 * Links cart product commodity to the Product Commodity model
	 *
	 * @param 	string 		$rowId
	 * @return 	void
	 */
	public function associateCartProductCommodityWithModel(string $rowId)
	{
		Cart::associate($rowId, ProductCommodity::class);
	}
	
	/**
	 * Remove a product commodity from the cart instance.
	 *
	 * @param 	string 		$rowId
	 * @return 	void
	 */
	public function removeCartProductCommodity(string $rowId)
	{
		Cart::remove($rowId);
	}
	
	/**
	 * Destroys a cart.
	 *
	 * @return 	void
	 */
	public function destroyCart()
	{
		Cart::destroy();
	}
}
