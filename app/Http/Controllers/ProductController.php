<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\{CartTrait, PageTrait, ProductTrait, TemplateTrait, ProductCategoryTrait};

class ProductController extends Controller
{
	use CartTrait, PageTrait, ProductTrait, TemplateTrait, ProductCategoryTrait;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('auth', [
			'except' => [
				'showProduct',
				'showProductCategory',
			]
		]);
		
		$this->middleware('guest', [
			'only' => [
				'showProduct',
				'showProductCategory',
			]
		]);
	}
	
	/**
	 * Get products view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_products')) {
			$title = 'Products';
			
			$subTitle = '';
			
			$products = $this->getProducts();
			
			return view('cp.products.index', compact('currentUser', 'title', 'subTitle', 'products'));
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Gets a product view (Front-end use only).
	 *
	 * @params	Request 	$request
	 * @params	string 		$stug
	 * @return 	Response
	 */
   	public function showProduct(Request $request, string $slug) : View
	{
		$currentUser = $this->getAuthenticatedUser();
		
		// Get the URL segments
		$segments = collect(explode('/', $slug));
		
		// Set slug based on the last segment
		$slug = $segments->last();
		
		// Get the requested product based on slug - if it doesnt exist, a 404 is thrown!
		$product = $this->getProductBySlug($slug);
		
		// We're going to use the browse page as our page - it is the products parent after all...
		$page = $this->getPageBySlug('browse');
		
		// Grab a cart instance	- available across all pages
		$cart = $this->getCartInstance('cart');
		
		// Grab any wishlist instances since user can add to cart and wishlist on products page
		$wishlistCart = $this->getCartInstance('wishlist');
		
		// Grab parameters
		$parameters = $request->route()->parameters();
		
		// Pass any global required data to the page template
		$parameters['currentUser'] = $currentUser;
		
		// Add the page to the parameters array - we want to pass the page model data to the template.
		$parameters['page'] = $page;
		
		$parameters['cart'] = $cart;
		
		$parameters['wishlistCart'] = $wishlistCart;
		
		$parameters['product'] = $product;
		
		// Selects the page template and injects any data required
		$this->preparePageTemplate($page, $parameters);
		
		return view('index', compact('currentUser', 'page', 'cart', 'wishlistCart'));
	}
	
	/**
	 * Gets a product category view (Front-end use only).
	 *
	 * @params	Request 	$request
	 * @params	string 		$stug
	 * @return 	Response
	 */
   	public function showProductCategory(Request $request, string $slug) : View
	{
		$currentUser = $this->getAuthenticatedUser();
		
		// Get the URL segments
		$segments = collect(explode('/', $slug));
		
		// Set slug based on the last segment
		$slug = $segments->last();
		
		// Get the requested product category based on slug - if it doesnt exist, a 404 is thrown!
		$productCategory = $this->getProductCategoryBySlug($slug);
		
		// We're going to use the browse page as our page - it is the products parent after all...
		$page = $this->getPageBySlug('browse');
		
		// Grab a cart instance	- available across all pages
		$cart = $this->getCartInstance('cart');
		
		// Grab any wishlist instances since user can add to cart and wishlist on products page
		$wishlistCart = $this->getCartInstance('wishlist');
		
		// Grab parameters
		$parameters = $request->route()->parameters();
		
		// Pass any global required data to the page template
		$parameters['currentUser'] = $currentUser;
		
		// Add the page to the parameters array - we want to pass the page model data to the template.
		$parameters['page'] = $page;
		
		$parameters['cart'] = $cart;
		
		$parameters['wishlistCart'] = $wishlistCart;
		
		$parameters['productCategory'] = $productCategory;
		
		// Selects the page template and injects any data required
		$this->preparePageTemplate($page, $parameters);
		
		return view('index', compact('currentUser', 'page', 'cart', 'wishlistCart'));
	}
}
