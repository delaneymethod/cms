<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Traits\CartTrait;
use App\Http\Traits\PageTrait;
use App\Http\Traits\ProductTrait;
use App\Http\Traits\TemplateTrait;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
	use CartTrait;
	use PageTrait;
	use ProductTrait;
	use TemplateTrait;

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
				'show'
			]
		]);
		
		$this->middleware('guest', [
			'only' => [
				'show'
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
	 * @params	string 		$slug
	 * @return 	Response
	 */
   	public function show(Request $request, string $slug)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		// Get the requested product based on slug - if it doesnt exist, a 404 is thrown!
		$product = $this->getProductBySlug($slug);
		
		// We're going to use the products page as our page - it is the products parent after all...
		$page = $this->getPageBySlug('products');
		
		// Since the requested product was found, then grab all the pages - builds our navigation and available across all pages
		$pages = $this->getPages();
		
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
		
		// Selects the pages template and injects any data required
		$this->preparePageTemplate($page, $parameters);
		
		return view('index', compact('currentUser', 'page', 'pages', 'cart', 'wishlistCart'));
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushProductsCache()
	{
		$this->flushCache('products');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushProductCache($product)
	{
		$this->flushCache('products:id:'.$product->id);
	}
}