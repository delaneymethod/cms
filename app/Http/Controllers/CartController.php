<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\{CartTrait, PageTrait, ProductTrait};

class CartController extends Controller
{
	use CartTrait;
	use PageTrait;
	use ProductTrait;

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
			
			return view('cp.carts.index', compact('currentUser', 'title', 'subTitle', 'carts'));
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
     * Stores a specific product in the cart.
     *
	 * @params Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
	    $currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_orders')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedProduct = $this->sanitizerInput($request->all());
			
			$rules = $this->getRules('cart');
			
			// Add some dynamic rules
			$rules['id'] = 'required|integer';
			$rules['action'] = 'required|string';
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedProduct, $rules);

			if ($validator->fails()) {
				$message = '';
				
				$errors = [];
				
				foreach ($validator->errors()->messages() as $error) {
					array_push($errors, $error[0]);
				}
				
				$message = implode(' ', $errors);
				
				abort(500, $message);
			}
			
			// Grab product model
			$product = $this->getProduct($cleanedProduct['id']);
			
			// Pick the correct cart to store the product in
			$this->setCartInstance($cleanedProduct['instance']);
			
			// Restore wishlist instances
			if ($cleanedProduct['instance'] == 'wishlist') {
				// User can only ever have 1 wishlist instance so no need for random strings
				$this->restoreCartInstance('wishlist_'.$currentUser->id);
			}
			
			// Note - You can pass a 3rd option with extra info ['size' => 'large']
			$cartProduct = $this->addCartProduct($product->id, $product->title, $product->price);
			
			// Link it to the Product model
			$this->associateCartProductWithModel($cartProduct->rowId);
			
			// Store wishlist instances
			if ($cleanedProduct['instance'] == 'wishlist') {	
				$this->storeCartInstance('wishlist_'.$currentUser->id);
			}
			
			// If the product was added to the cart from the wishlist, an action "remove_wishlist" will have been passed
			if ($cleanedProduct['instance'] == 'cart' && $cleanedProduct['action'] == 'remove_wishlist') {
				// Quickly switch cart instances
				$this->setCartInstance('wishlist');
				
				// Grab any new wishlist products from the database incase of another user session
				$this->restoreCartInstance('wishlist_'.$currentUser->id);
				
				// Grab the product from the wishlist
				$wishlistProduct = $this->searchCart($cleanedProduct['id']);
				
				// Make sure we actually have a product before trying to remove it
				if ($wishlistProduct->count() > 0) {
					// There should only be 1 product returned in the search...so grab the first item from the collection.
					$wishlistProduct = $wishlistProduct->first();
					
					// remove product from the cart
					$this->removeCartProduct($wishlistProduct->rowId);
				}
				
				// Store wishlist instances again if wishlist still have products
				if ($this->getCartCount() > 0) {	
					$this->storeCartInstance('wishlist_'.$currentUser->id);
				}
				
				// Quickly switch cart instances back
				$this->setCartInstance('cart');
			}
			
			flash('Product was added to your '.$cleanedProduct['instance'].'!', $level = 'success');
			
			return redirect('/cart');
		}

		abort(403, 'Unauthorised action');
	}
    
    /**
	 * Updates a specific product in the cart.
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
			$cleanedProduct = $this->sanitizerInput($request->all());
			
			$rules = $this->getRules('cart');
			
			// Add some dynamic rules
			$rules['quantity'] = 'required|integer';
				
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedProduct, $rules);
	
			if ($validator->fails()) {
				$message = '';
				
				$errors = [];
				
				foreach ($validator->errors()->messages() as $error) {
					array_push($errors, $error[0]);
				}
				
				$message = implode(' ', $errors);
				
				abort(500, $message);
			}
			
			// Grab product model - makes sure product actually exists as this call with fail if not!
			$product = $this->getProduct($cleanedProduct['id']);
			
			// Pick the correct cart to update the product in
			$this->setCartInstance($cleanedProduct['instance']);
			
			// Make sure the product actually exists in the cart too!
			$cartProduct = $this->getCartProduct($rowId);
			
			if ($cleanedProduct['quantity'] == 0) {
				$this->removeCartProduct($cartProduct->rowId);
				
				flash('Product was removed from your '.$cleanedProduct['instance'].'!', $level = 'info');
			} else {
				// Pass in row id and quantity
				$this->updateCartProductQuantity($cartProduct->rowId, $cleanedProduct['quantity']);
			}
			
			return back();
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Deletes a specific product in the cart or destroys the cart.
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
			$cleanedProduct = $this->sanitizerInput($request->all());
			
			// Check the action
			if ($cleanedProduct['action'] == 'delete_cart') {
				// Pick the correct cart to destory
				$this->setCartInstance($cleanedProduct['instance']);
				
				$this->destroyCart();
		
				flash('Your '.$cleanedProduct['instance'].' was deleted!', $level = 'info');
				
				return back();
			} else if ($cleanedProduct['action'] == 'delete_product') {
				$rules = $this->getRules('cart');
			
				// Add some dynamic rules
				$rules['id'] = 'required|integer';
				$rules['row_id'] = 'required|alpha_num';
				
				// Make sure all the input data is what we actually save
				$validator = $this->validatorInput($cleanedProduct, $rules);
	
				if ($validator->fails()) {
					$message = '';
					
					$errors = [];
					
					foreach ($validator->errors()->messages() as $error) {
						array_push($errors, $error[0]);
					}
					
					$message = implode(' ', $errors);
					
					abort(500, $message);
				}
				
				// Grab product model
				$product = $this->getProduct($cleanedProduct['id']);
				
				// Pick the correct cart to delete product from
				$this->setCartInstance($cleanedProduct['instance']);
				
				// Restore wishlist instances
				if ($cleanedProduct['instance'] == 'wishlist') {
					// User can only ever have 1 wishlist instance so no need for random strings
					$this->restoreCartInstance('wishlist_'.$currentUser->id);
				}
				
				$this->removeCartProduct($cleanedProduct['row_id']);
				
				// Store wishlist instances again if wishlist still have products
				if ($cleanedProduct['instance'] == 'wishlist' && $this->getCartCount() > 0) {	
					$this->storeCartInstance('wishlist_'.$currentUser->id);
				}
				
				flash('Product was removed from your '.$cleanedProduct['instance'].'!', $level = 'info');
				
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
			$identifier = implode('_', [str_random(30), $currentUser->id]);
			
			$identifier = strtolower($identifier);
				
			// Save instance to database
			$this->storeCartInstance($identifier);
			
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
}
