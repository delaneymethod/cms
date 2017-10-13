<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Content, ProductManufacturer};
use App\Http\Traits\{CartTrait, PageTrait, ContentTrait, TemplateTrait, ProductManufacturerTrait};

class ProductManufacturerController extends Controller
{
	use CartTrait, PageTrait, ContentTrait, TemplateTrait, ProductManufacturerTrait;
	
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
	}

	/**
	 * Gets a product manufacturer view (Front-end use only).
	 *
	 * @params	Request 	$request
	 * @params	string 		$slug
	 * @return 	Response
	 */
   	public function show(Request $request, string $slug) : View
	{
		$currentUser = $this->getAuthenticatedUser();
		
		// Get the requested product manufacturer based on slug - if it doesnt exist, a 404 is thrown!
		$productManufacturer = $this->getProductManufacturerBySlug($slug);
		
		// We're going to use the manufacturers page as our page - it is the product manufacturers parent after all...
		$page = $this->getPageBySlug('manufacturers');
		
		// Grab a cart instance	- available across all pages
		$cart = $this->getCartInstance('cart');
		
		// Grab any wishlist instances since user can add to cart and wishlist on product manufacturers page
		$wishlistCart = $this->getCartInstance('wishlist');
		
		// Grab parameters
		$parameters = $request->route()->parameters();
		
		// Pass any global required data to the page template
		$parameters['currentUser'] = $currentUser;
		
		$parameters['page'] = $page;
		
		$parameters['cart'] = $cart;
		
		$parameters['wishlistCart'] = $wishlistCart;
		
		$parameters['productManufacturer'] = $productManufacturer;
		
		// Selects the page template and injects any data required
		$this->preparePageTemplate($page, $parameters);
		
		return view('index', compact('currentUser', 'page', 'cart', 'wishlistCart'));
	}
}
