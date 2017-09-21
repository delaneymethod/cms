<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use Cart;
use Gloudemans\Shoppingcart\CartItem;
use App\Models\{Product, Cart as Kart};
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
	 * Gets specific product from cart instance based on row id.
	 *
	 * @param 	string			$rowId
	 * @return 	Object
	 */
	public function getCartProduct(string $rowId) : CartItem
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
			'products' => Cart::content(),
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
	 * Adds a product to the cart instance.
	 *
	 * @param 	int 		$id
	 * @param 	string 		$title
	 * @param 	float 		$price
	 * @return 	Object
	 */
	public function addCartProduct(int $id, string $title, float $price) : CartItem
	{
		return Cart::add($id, $title, 1, $price);
	}
	
	/**
	 * Updates a products quantity in the cart instance.
	 *
	 * @param 	string 		$rowId
	 * @param 	int 		$quantity
	 * @return 	void
	 */
	public function updateCartProductQuantity(string $rowId, int $quantity)
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
	 * Searches cart instance for product based on product id
	 *
	 * @param 	int			$id
	 * @return 	collection
	 */
	public function searchCart(int $id) : SupportCollectionResponse
	{
		return Cart::search(function ($product, $rowId) use ($id) {
			return $product->id === $id;
		});
	}
	
	/**
	 * Links cart product to the Product model
	 *
	 * @param 	string 		$rowId
	 * @return 	void
	 */
	public function associateCartProductWithModel(string $rowId)
	{
		Cart::associate($rowId, Product::class);
	}
	
	/**
	 * Remove a product from the cart instance.
	 *
	 * @param 	string 		$rowId
	 * @return 	void
	 */
	public function removeCartProduct(string $rowId)
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
