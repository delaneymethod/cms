<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use Cart;
use CartHelper;
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
	 * Get the specified cart based on user id.
	 *
	 * @param 	int 		$userId
	 * @return 	Object
	 */
	public function getCartsByUserId(int $userId) : EloquentCollectionResponse
	{
		return Kart::where('user_id', $userId)->get();
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
		return Kart::where('identifier', $identifier)->where('instance', $instance)->get();
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
		$carts = $this->getCartsByUserId($userId);
		
		$carts = $carts->filter(function ($cart) {
			return $cart->instance == 'cart';
		});
		
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
	 * Restructre the data so its grouped by product
	 *
	 * @param 	Kart 		$cart
	 * @return 	Kart
	 */
	public function setCartItems($cart)
	{
		$cartItems = $cart->product_commodities;
		
		$cart->cartTotalItems = count($cartItems);
		
		$cart->cartItems = $this->groupCartItemsByProduct($cartItems);
		
		return $cart;
	}
	
	/**
	 * Groups cart items by product
	 *
	 * @param 	string 		$cartItem
	 * @return 	array
	 */
	public function groupCartItemsByProduct(SupportCollectionResponse $cartItems) : array
	{
		// Create an array with both product and product commodity info so we can group by product
		$productCommodities = [];
		
		foreach ($cartItems as $cartItem) {
			array_push($productCommodities, [
				'id' => $cartItem->id,
				'title' => $cartItem->name,
				'quantity' => $cartItem->qty,
				'product_id' => $cartItem->model->product->id,
				'product_title' => $cartItem->model->product->title,
				'product_url' => $cartItem->model->product->url,
				'product_image_url' => $cartItem->model->product->image_url,
			]);
		}
		
		// Create new array grouped by product title
		$tmp = array();
		
		foreach ($productCommodities as $productCommodity) {
			$tmp[$productCommodity['product_title']][] = [
				'id' => $productCommodity['id'],
				'title' => $productCommodity['title'],
				'quantity' => $productCommodity['quantity'],
				'product_id' => $productCommodity['product_id'],
				'product_title' => $productCommodity['product_title'],
				'product_url' => $productCommodity['product_url'],
				'product_image_url' => $productCommodity['product_image_url'],
			];
		}
		
		// Now add back in product info
		$cartItems = [];
		
		foreach ($tmp as $productTitle => $productCommodities) {
			$cartItems[] = [
				'product_id' => $productCommodities[0]['product_id'],
				'product_title' => $productTitle,
				'product_url' => $productCommodities[0]['product_url'],
				'product_image_url' => $productCommodities[0]['product_image_url'],
				'product_commodities' => $productCommodities,
			];
		}
		
		return $cartItems;
	}
	
	/**
	 * Stores cart instance.
	 *
	 * !! Overrides "store" method from the 3rd party vendor library !!
	 *
	 * @param 	string 		$instance
	 * @param 	int 		$userId 
	 * @return 	void
	 */
	public function storeCartInstance(string $identifier, int $userId)
	{
		CartHelper::store($identifier, $userId);
	}
	
	/**
	 * Restores cart instance.
	 *
	 * @param 	string 		$instance
	 * @param 	int 		$userId 
	 * @return 	void
	 */
	public function restoreCartInstance(string $identifier)
	{
		Cart::restore($identifier);
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
