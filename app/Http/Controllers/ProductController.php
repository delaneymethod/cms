<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Traits\CartTrait;
use App\Http\Traits\PageTrait;
use App\Http\Traits\ProductTrait;
use App\Http\Controllers\Controller;

class ProductController extends Controller
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
		
		$product = $this->getProductBySlug($slug);
		
		$pages = $this->getPages();
		
		// Select any cart instances from the current session
		$cart = $this->getCartInstance('cart');
		
		// Select any wishlist instances from the current session
		$wishlistCart = $this->getCartInstance('wishlist');
			
		return view('templates.product', compact('currentUser', 'product', 'pages', 'cart', 'wishlistCart'));
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
