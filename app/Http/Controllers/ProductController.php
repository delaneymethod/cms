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
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
				'show',
			]
		]);
		
		$this->middleware('guest', [
			'only' => [
				'show',
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
	 * Gets a product / product category view (Front-end use only).
	 *
	 * Since the URL structure is dynamic/flexible, things can get a bit tricky. E.g we can do:
	 * 	- /products/<product-category>
	 *  - /products/<product-category>/<product-category>
	 *  - /products/<product-category>/<product-category>/<product-category>/<NTH-product-category>
	 *  - /products/<product-category>/<product>
	 *  - /products/<product>
	 *
	 * Basically the segment depth can be any depth - all we are interested in is the last segment.
	 *
	 * We check if the slug macthes both a product first and product category. 
	 * We do this because some products have same name/slug as its product category.
	 * 	 
	 * @params	Request 	$request
	 * @params	string 		$stug
	 * @return 	Response
	 */
   	public function show(Request $request, string $slug) : View
	{
		$currentUser = $this->getAuthenticatedUser();
		
		// Get the URL segments
		$segments = collect(explode(DIRECTORY_SEPARATOR, $slug));
		
		// Grab 2nd last slug value
		$secondLastSlug = '';
		
		if (count($segments) > 2) {
			$secondLastSlug = array_slice($segments->toArray(), -2, 1);
		
			$secondLastSlug = $secondLastSlug[0];
		}
		
		// Set slug based on the last segment
		$slug = $segments->last();
		
		$modelType = '';
		
		$modelData = null;
		
		// If 2nd last slug and last slug values match, then both the product and the product category have same title, slug etc so load up product
		if ($slug == $secondLastSlug) {
			$modelType = 'product';
				
			$modelData = $this->getProductBySlug($slug);
		} else {
			try {
				$modelType = 'productCategory';
				
				$modelData = $this->getProductCategoryBySlug($slug);
			} catch (ModelNotFoundException $modelNotFoundException) {
				$modelType = 'product';
				
				// If it doesnt exist, a 404 is thrown - we dont want to catch this - allow it to load a 404 page!
				$modelData = $this->getProductBySlug($slug);
			}
		}
		// else catch... 404 is thrown regardless
		
		// We're going to use the products page as our page - it is the products parent after all...
		$page = $this->getPageBySlug('products');
		
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
		
		// Dynamically set type and data
		$parameters[$modelType] = $modelData;
		
		// Selects the page template and injects any data required
		$this->preparePageTemplate($page, $parameters);
		
		return view('index', compact('currentUser', 'page', 'cart', 'wishlistCart'));
	}
}
