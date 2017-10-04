<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\{UserTrait, CartTrait, PageTrait, ProductCommodityTrait};

class CartController extends Controller
{
	use UserTrait, CartTrait, PageTrait, ProductCommodityTrait;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('auth');
	}
	
	/**
	 * Get carts view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_carts')) {
			$title = 'Saved Carts';
			
			$subTitle = '';
			
			$carts = $this->getCarts();
			
			$carts = $this->filterCarts($carts);
			
			return view('cp.carts.index', compact('currentUser', 'title', 'subTitle', 'carts'));
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a cart.
	 *
	 * @params	Request 	$request
	 * @param	string		$identifier
	 * @return 	Response
	 */
   	public function show(Request $request, string $identifier)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_carts')) {
			$cart = $this->getCart($identifier);
			
			$this->authorize('userOwnsThis', $cart);
			
			// Convert cart items into usable format so we can restructre the data so its grouped by product.
			$cartItems = unserialize($cart->content);
			
			$cart->cartTotalItems = count($cartItems);
			
			$cart->cartItems = $this->groupCartItemsByProduct($cartItems);
			
			$title = 'View Cart';
		
			$subTitle = 'Carts';
			
			return view('cp.carts.show', compact('currentUser', 'title', 'subTitle', 'cart'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Stores a specific product commodity in the cart.
     *
	 * @params Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
	    $currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_orders')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedProductCommodity = $this->sanitizerInput($request->all());
			
			$rules = $this->getRules('cart');
			
			// Add some dynamic rules
			$rules['id'] = 'required|integer';
			$rules['action'] = 'required|string';
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedProductCommodity, $rules);

			if ($validator->fails()) {
				$message = '';
				
				$errors = [];
				
				foreach ($validator->errors()->messages() as $error) {
					array_push($errors, $error[0]);
				}
				
				$message = implode(' ', $errors);
				
				abort(500, $message);
			}
			
			// Grab product commodity model
			$productCommodity = $this->getProductCommodity($cleanedProductCommodity['id']);
			
			// Pick the correct cart to store the product commodity in
			$this->setCartInstance($cleanedProductCommodity['instance']);
			
			// Restore wishlist instances
			if ($cleanedProductCommodity['instance'] == 'wishlist') {
				// User can only ever have 1 wishlist instance so no need for random strings
				$this->restoreCartInstance('wishlist_'.$currentUser->id);
			}
			
			// Note - You can pass a 3rd option with extra info ['size' => 'large']
			$cartProductCommodity = $this->addCartProductCommodity($productCommodity->id, $productCommodity->title, $productCommodity->price);
			
			// Link it to the Product Commodity model
			$this->associateCartProductCommodityWithModel($cartProductCommodity->rowId);
			
			// Store wishlist instances
			if ($cleanedProductCommodity['instance'] == 'wishlist') {	
				$this->storeCartInstance('wishlist_'.$currentUser->id, $currentUser->id);
			}
			
			// If the product commodity was added to the cart from the wishlist, an action "remove_wishlist" will have been passed
			if ($cleanedProductCommodity['instance'] == 'cart' && $cleanedProductCommodity['action'] == 'remove_wishlist') {
				// Quickly switch cart instances
				$this->setCartInstance('wishlist');
				
				// Grab any new wishlist product commodities from the database incase of another user session
				$this->restoreCartInstance('wishlist_'.$currentUser->id);
				
				// Grab the product commodity from the wishlist
				$wishlistProductCommodity = $this->searchCart($cleanedProductCommodity['id']);
				
				// Make sure we actually have a product before trying to remove it
				if ($wishlistProductCommodity->count() > 0) {
					// There should only be 1 product commodity returned in the search...so grab the first item from the collection.
					$wishlistProductCommodity = $wishlistProductCommodity->first();
					
					// remove product commodity from the cart
					$this->removeCartProductCommodity($wishlistProductCommodity->rowId);
				}
				
				// Store wishlist instances again if wishlist still have products
				if ($this->getCartCount() > 0) {	
					$this->storeCartInstance('wishlist_'.$currentUser->id, $currentUser->id);
				}
				
				// Quickly switch cart instances back
				$this->setCartInstance('cart');
			}
			
			flash('Item was added to your '.$cleanedProductCommodity['instance'].'!', $level = 'success');
			
			// If we are redirecting user back to previous page, then we set the new route here
			$redirectTo = $request->get('redirectTo');
			
			if (!empty($redirectTo)) {
				return redirect($redirectTo);	
			}
			
			return redirect('/cart');
		}

		abort(403, 'Unauthorised action');
	}
    
    /**
	 * Updates a specific product commodity in the cart.
	 *
	 * @params	Request 	$request
	 * @param	string			$rowId
	 * @return 	Response
	 */
   	public function update(Request $request, string $rowId)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_orders')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedProductCommodity = $this->sanitizerInput($request->all());
			
			$rules = $this->getRules('cart');
			
			// Add some dynamic rules
			$rules['quantity'] = 'required|integer';
				
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedProductCommodity, $rules);
	
			if ($validator->fails()) {
				$message = '';
				
				$errors = [];
				
				foreach ($validator->errors()->messages() as $error) {
					array_push($errors, $error[0]);
				}
				
				$message = implode(' ', $errors);
				
				abort(500, $message);
			}
			
			// Grab product commodity model - makes sure product commodity actually exists as this call with fail if not!
			$productCommodity = $this->getProductCommodity($cleanedProductCommodity['id']);
			
			// Pick the correct cart to update the product in
			$this->setCartInstance($cleanedProductCommodity['instance']);
			
			// Make sure the product commodity actually exists in the cart too!
			$cartProductCommodity = $this->getCartProductCommodity($rowId);
			
			if ($cleanedProductCommodity['quantity'] == 0) {
				$this->removeCartProductCommodity($cartProductCommodity->rowId);
				
				flash('Item was removed from your '.$cleanedProductCommodity['instance'].'!', $level = 'info');
			} else {
				// Pass in row id and quantity
				$this->updateCartProductCommodityQuantity($cartProductCommodity->rowId, $cleanedProductCommodity['quantity']);
			}
			
			return back();
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Deletes a specific product commodity in the cart or destroys the cart.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function delete(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_orders')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedProductCommodity = $this->sanitizerInput($request->all());
			
			// Check the action
			if ($cleanedProductCommodity['action'] == 'delete_cart') {
				// Pick the correct cart to destory
				$this->setCartInstance($cleanedProductCommodity['instance']);
				
				$this->destroyCart();
		
				flash('Your '.$cleanedProductCommodity['instance'].' was deleted!', $level = 'info');
				
				return back();
			} else if ($cleanedProductCommodity['action'] == 'delete_product_commodity') {
				$rules = $this->getRules('cart');
			
				// Add some dynamic rules
				$rules['id'] = 'required|integer';
				$rules['row_id'] = 'required|alpha_num';
				
				// Make sure all the input data is what we actually save
				$validator = $this->validatorInput($cleanedProductCommodity, $rules);
	
				if ($validator->fails()) {
					$message = '';
					
					$errors = [];
					
					foreach ($validator->errors()->messages() as $error) {
						array_push($errors, $error[0]);
					}
					
					$message = implode(' ', $errors);
					
					abort(500, $message);
				}
				
				// Grab product commodity model
				$productCommodity = $this->getProductCommodity($cleanedProductCommodity['id']);
				
				// Pick the correct cart to delete product commodity from
				$this->setCartInstance($cleanedProductCommodity['instance']);
				
				// Restore wishlist instances
				if ($cleanedProductCommodity['instance'] == 'wishlist') {
					// User can only ever have 1 wishlist instance so no need for random strings
					$this->restoreCartInstance('wishlist_'.$currentUser->id);
				}
				
				$this->removeCartProductCommodity($cleanedProductCommodity['row_id']);
				
				// Store wishlist instances again if wishlist still have product commodities
				if ($cleanedProductCommodity['instance'] == 'wishlist' && $this->getCartCount() > 0) {	
					$this->storeCartInstance('wishlist_'.$currentUser->id, $currentUser->id);
				}
				
				flash('Item was removed from your '.$cleanedProductCommodity['instance'].'!', $level = 'info');
				
				return back();
			} else {
				abort(500, 'Action not found');
			}
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Saves current cart instance to the database.
     *
	 * @params Request 	$request
     * @return Response
     */
	public function save(Request $request) 
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('create_orders')) {
			// Switch to cart instance 
			$this->setCartInstance('cart');
			
			// Create a random lowercase identifier with current users id
			$identifier = str_random(30);
			
			$identifier = strtolower($identifier);
				
			// Save instance to database
			$this->storeCartInstance($identifier, $currentUser->id);
			
			// Empty cart instance
			$this->destroyCart();
			
			flash('Cart was saved!', $level = 'info');
				
			return back();
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Restores a specific cart from the database.
     *
	 * @params Request 	$request
	 * @params string 	$identifier
     * @return Response
     */
	public function restore(Request $request, string $identifier) 
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('create_orders')) {
			// Set current cart instance to restored cart
			$this->setCartInstance('cart');
			
			$this->restoreCartInstance($identifier);
			
			flash('Cart was restored!', $level = 'info');
				
			return back();
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Saves user id billing info into cart session and takes user to the next step.
     *
	 * @params Request 	$request
     * @return Response
     */
	public function checkoutStep1(Request $request) 
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('create_orders')) {
			$request->session()->put('cart.user_id', $request->get('user_id'));
			
			return redirect('/cart/checkout/step-2');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Saves user id shipping info into cart session and takes user to the next step.
     *
	 * @params Request 	$request
     * @return Response
     */
	public function checkoutStep2(Request $request) 
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('create_orders')) {
			$userId = $request->session()->get('cart.user_id');
			
			// Make sure step 2's user id is the same as step 1's user id
			if ($userId == $currentUser->id) {
				$request->session()->put('cart.location_id', $request->get('location_id'));
				
				$request->session()->put('cart.shipping_method_id', $request->get('shipping_method_id'));
				
				$request->session()->put('cart.notes', $request->get('notes'));
				
				return redirect('/cart/checkout/step-3');
			}
			
			abort(403, 'Unauthorised action');
		}

		abort(403, 'Unauthorised action');
	}
}
