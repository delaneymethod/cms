<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Controllers;

use DB;
use Log;
use Exception;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Events\{KeywordEvent, ProductCreatedEvent, ProductUpdatedEvent, ProductDeletedEvent};
use App\Http\Traits\{CartTrait, PageTrait, ProductTrait, TemplateTrait, ProductCategoryTrait};
use App\Events\{ProductVatRatesCreatedEvent, ProductVatRatesUpdatedEvent, ProductVatRatesDeletedEvent};
use App\Events\{ProductStandardsCreatedEvent, ProductStandardsUpdatedEvent, ProductStandardsDeletedEvent};
use App\Events\{ProductAttributesCreatedEvent, ProductAttributesUpdatedEvent, ProductAttributesDeletedEvent};
use App\Events\{ProductCategoriesCreatedEvent, ProductCategoriesUpdatedEvent, ProductCategoriesDeletedEvent};
use App\Events\{ProductCommoditiesCreatedEvent, ProductCommoditiesUpdatedEvent, ProductCommoditiesDeletedEvent};
use App\Events\{ProductManufacturersCreatedEvent, ProductManufacturersUpdatedEvent, ProductManufacturersDeletedEvent};
use App\Events\{ProductCharacteristicsCreatedEvent, ProductCharacteristicsUpdatedEvent, ProductCharacteristicsDeletedEvent};
use App\Events\{ProductStandardOrganisationsAddedEvent, ProductStandardOrganisationsUpdatedEvent, ProductStandardOrganisationsDeletedEvent};

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
				'search',
				'webhook',
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
	
	/**
     * Searches products based on keywords 
     *
	 * @params Request 	$request
     * @return Response
     */
    public function search(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
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
		$parameters['search'] = true;
		
		$parameters['keywords'] = $request->get('keywords');
		
		if (!empty($parameters['keywords'])) {
			KeywordEvent::dispatch($parameters['keywords']);
		}
		
		// Selects the page template and injects any data required
		$this->preparePageTemplate($page, $parameters);
		
		return view('index', compact('currentUser', 'page', 'cart', 'wishlistCart'));
	}
	
	/**
     * Receives a webhook notification from 3rd party applications/services
     *
	 * @params Request 	$request
     * @return Response
     */
    public function webhook(Request $request) 
    {
	    $cleanedEvent = $this->sanitizerInput($request->all());
	    
	    if (!empty($cleanedEvent['event_id'])) {
		    switch ($cleanedEvent['event_type']) {
				case 'products.added':
					// Make sure we convert column names to match the model
					$products = ProductTransformer::transformProducts($cleanedEvent['data']);
					
					collect($products)->each(function ($data) {
						// Insert it
						$product = Product::create($data);
						
						if ($product) {
							ProductCreatedEvent::dispatch($product);
						}
					});
					
					break;
					
				case 'products.updated':
					// Make sure we convert column names to match the model
					$products = ProductTransformer::transformProducts($cleanedEvent['data']);
					
					collect($products)->each(function ($data) {
						// Grab and update it
						$product = Product::find($data['id']);
						
						if ($product) {
							// Mass assignment
							$product->fill($data);
						
							$product->save();
						
							ProductUpdatedEvent::dispatch($product);
						}
					});
					
					break;
					
				case 'products.deleted':	
					// Make sure we convert column names to match the model
					$products = ProductTransformer::transformProducts($cleanedEvent['data']);
					
					collect($products)->each(function ($data) {
						// Delete it
						$product = Product::find($data['id']);
						
						if ($product) {
							ProductDeletedEvent::dispatch($product);
							
							$product->delete();
						}
					});
					
					break;
					
				case 'product_categories.added':
					// Make sure we convert column names to match the model
					$productCategories = ProductTransformer::transformProductCategories($cleanedEvent['data']);
					
					collect($productCategories)->each(function ($data) {
						// Insert it
						$productCategory = ProductCategory::create($data);
						
						if ($productCategory) {
							ProductCategoryCreatedEvent::dispatch($productCategory);
						}
					});
					
					break;
					
				case 'product_categories.updated':
					// Make sure we convert column names to match the model
					$productCategories = ProductTransformer::transformProductCategories($cleanedEvent['data']);
					
					collect($productCategories)->each(function ($data) {
						// Grab and update it
						$productCategory = ProductCategory::find($data['id']);
						
						if ($productCategory) {
							// Mass assignment
							$productCategory->fill($data);
							
							$productCategory->save();
							
							ProductCategoryUpdatedEvent::dispatch($productCategory);
						}
					});
					
					break;
				
				case 'product_categories.deleted':
					// Make sure we convert column names to match the model
					$productCategories = ProductTransformer::transformProductCategories($cleanedEvent['data']);
					
					collect($productCategories)->each(function ($data) {
						// Delete it
						$productCategory = ProductCategory::find($data['id']);
						
						if ($productCategory) {
							ProductCategoryDeletedEvent::dispatch($productCategory);
							
							$productCategory->delete();
						}
					});
					
					break;
					
				case 'product_commodities.added':
					// Make sure we convert column names to match the model
					$productCommodities = ProductTransformer::transformProductCommodities($cleanedEvent['data']);
					
					collect($productCommodities)->each(function ($data) {
						// Insert it
						$productCommodity = ProductCommodity::create($data);
						
						if ($productCommodity) {
							ProductCommodityCreatedEvent::dispatch($productCommodity);
						}
					});
					
					break;
					
				case 'product_commodities.updated':
					// Make sure we convert column names to match the model
					$productCommodities = ProductTransformer::transformProductCommodities($cleanedEvent['data']);
				
					collect($productCommodities)->each(function ($data) {
						// Grab and update it
						$productCommodity = ProductCommodity::find($data['id']);
						
						if ($productCommodity) {
							// Mass assignment
							$productCommodity->fill($data);
							
							$productCommodity->save();
							
							ProductCommodityUpdatedEvent::dispatch($productCommodity);
						}
					});
					
					break;
				
				case 'product_commodities.deleted':
					// Make sure we convert column names to match the model
					$productCommodities = ProductTransformer::transformProductCommodities($cleanedEvent['data']);
					
					collect($productCommodities)->each(function ($data) {
						// Delete it
						$productCommodity = ProductCommodity::find($data['id']);
						
						if ($productCommodity) {
							ProductCommodityDeletedEvent::dispatch($productCommodity);
							
							$productCommodity->delete();
						}
					});
					
					break;
					
				case 'product_characteristics.added':
					// Make sure we convert column names to match the model
					$productCharacteristics = ProductTransformer::transformProductCharacteristics($cleanedEvent['data']);
					
					collect($productCharacteristics)->each(function ($data) {
						// Insert it
						$productCharacteristic = ProductCharacteristic::create($data);
						
						if ($productCharacteristic) {
							ProductCharacteristicCreatedEvent::dispatch($productCharacteristic);
						}
					});
					
					break;
				
				case 'product_characteristics.updated':
					// Make sure we convert column names to match the model
					$productCharacteristics = ProductTransformer::transformProductCharacteristics($cleanedEvent['data']);
					
					collect($productCharacteristics)->each(function ($data) {
						// Grab and update it
						$productCharacteristic = ProductCharacteristic::find($data['id']);
					
						if ($productCharacteristic) {
							// Mass assignment
							$productCharacteristic->fill($data);
							
							$productCharacteristic->save();
							
							ProductCharacteristicUpdatedEvent::dispatch($productCharacteristic);
						}
					});
					
					break;
					
				case 'product_characteristics.deleted':
					// Make sure we convert column names to match the model
					$productCharacteristics = ProductTransformer::transformProductCharacteristics($cleanedEvent['data']);
					
					collect($productCharacteristics)->each(function ($data) {
						// Delete it
						$productCharacteristic = ProductCharacteristic::find($data['id']);
						
						if ($productCharacteristic) {
							ProductCharacteristicDeletedEvent::dispatch($productCharacteristic);
							
							$productCharacteristic->delete();
						}
					});
										
					break;
					
				case 'product_manufacturers.added':
					// Make sure we convert column names to match the model
					$productManufacturers = ProductTransformer::transformProductManufacturers($cleanedEvent['data']);
					
					collect($productManufacturers)->each(function ($data) {
						// Insert it
						$productManufacturer = ProductManufacturer::create($data);
						
						if ($productManufacturer) {
							ProductManufacturerCreatedEvent::dispatch($productManufacturer);
						}
					});
					
					break;
					
				case 'product_manufacturers.updated':
					// Make sure we convert column names to match the model
					$productManufacturers = ProductTransformer::transformProductManufacturers($cleanedEvent['data']);
				
					collect($productManufacturers)->each(function ($data) {
						// Grab and update it
						$productManufacturer = ProductManufacturer::find($data['id']);
						
						if ($productManufacturer) {
							// Mass assignment
							$productManufacturer->fill($data);
							
							$productManufacturer->save();
							
							ProductManufacturerUpdatedEvent::dispatch($productManufacturer);
						}
					});
					
					break;
					
				case 'product_manufacturers.deleted':
					// Make sure we convert column names to match the model
					$productManufacturers = ProductTransformer::transformProductManufacturers($cleanedEvent['data']);
					
					collect($productManufacturers)->each(function ($data) {
						// Delete it
						$productManufacturer = ProductManufacturer::find($data['id']);
						
						if ($productManufacturer) {
							ProductManufacturerDeletedEvent::dispatch($productManufacturer);
							
							$productManufacturer->delete();
						}
					});
					
					break;
					
				case 'product_standard.updated':
					// Make sure we convert column names to match the model
					$productStandards = ProductTransformer::transformProductStandard($cleanedEvent['data']);
					
					$productStandards = collect($productStandards)->groupBy('product_id');
					
					collect($productStandards)->each(function ($data) {
						$productId = $data->pluck('product_id')->unique()->first();
						
						$productStandardIds = $data->pluck('product_standard_id')->toArray();
						
						// Grab and update it
						$product = Product::find($productId);
						
						if ($product) {	
							// Mass assignment
							$product->setProductStandards($productStandardIds);
							
							$product->save();
							
							ProductUpdatedEvent::dispatch($product);
						}
					});
					
					break;
				
				case 'product_standards.added':
					// Make sure we convert column names to match the model
					$productStandards = ProductTransformer::transformProductStandards($cleanedEvent['data']);
					
					collect($productStandards)->each(function ($data) {
						// Insert it
						$productStandard = ProductStandard::create($data);
						
						if ($productStandard) {
							ProductStandardCreatedEvent::dispatch($productStandard);
						}
					});
					
					break;
					
				case 'product_standards.updated':
					// Make sure we convert column names to match the model
					$productStandards = ProductTransformer::transformProductStandards($cleanedEvent['data']);
					
					collect($productStandards)->each(function ($data) {
						// Grab and update it
						$productStandard = ProductStandard::find($data['id']);
						
						if ($productStandard) {
							// Mass assignment
							$productStandard->fill($data);
							
							$productStandard->save();
							
							ProductStandardUpdatedEvent::dispatch($productStandard);
						}
					});
					
					break;
					
				case 'product_standards.deleted':
					// Make sure we convert column names to match the model
					$productStandards = ProductTransformer::transformProductStandards($cleanedEvent['data']);
					
					collect($productStandards)->each(function ($data) {
						// Delete it
						$productStandard = ProductStandard::find($data['id']);
						
						if ($productStandard) {
							ProductStandardDeletedEvent::dispatch($productStandard);
							
							$productStandard->delete();
						}
					});
					
					break;
					
				case 'product_standard_organisations.added':
					// Make sure we convert column names to match the model
					$productStandardOrganisations = ProductTransformer::transformProductStandardOrganisations($cleanedEvent['data']);
					
					collect($productStandardOrganisations)->each(function ($data) {
						// Insert it
						$productStandardOrganisation = ProductStandardOrganisation::create($data);
						
						if ($productStandardOrganisation) {
							ProductStandardOrganisationCreatedEvent::dispatch($productStandardOrganisation);
						}
					});
					
					break;
				
				case 'product_standard_organisations.updated':
					// Make sure we convert column names to match the model
					$productStandardOrganisations = ProductTransformer::transformProductStandardOrganisations($cleanedEvent['data']);
					
					collect($productStandardOrganisations)->each(function ($data) {
						// Grab and update it
						$productStandardOrganisation = ProductStandardOrganisation::find($data['id']);
						
						if ($productStandardOrganisation) {
							// Mass assignment
							$productStandardOrganisation->fill($data);
							
							$productStandardOrganisation->save();
							
							ProductStandardOrganisationUpdatedEvent::dispatch($productStandardOrganisation);
						}
					});
					
					break;
					
				case 'product_standard_organisations.deleted':
					// Make sure we convert column names to match the model
					$productStandardOrganisations = ProductTransformer::transformProductStandardOrganisations($cleanedEvent['data']);
					
					collect($productStandardOrganisations)->each(function ($data) {
						// Delete it
						$productStandardOrganisation = ProductStandardOrganisation::find($data['id']);
						
						if ($productStandardOrganisation) {
							ProductStandardOrganisationDeletedEvent::dispatch($productStandardOrganisation);
							
							$productStandardOrganisation->delete();
						}
					});
					
					break;
					
				case 'product_attributes.added':
					// Make sure we convert column names to match the model
					$productAttributes = ProductTransformer::transformProductAttributes($cleanedEvent['data']);
					
					collect($productAttributes)->each(function ($data) {
						// Insert it
						$productAttribute = ProductAttribute::create($data);
						
						if ($productAttribute) {
							ProductAttributeCreatedEvent::dispatch($productAttribute);
						}
					});
					
					break;
					
				case 'product_attributes.updated':
					// Make sure we convert column names to match the model
					$productAttributes = ProductTransformer::transformProductAttributes($cleanedEvent['data']);
					
					collect($productAttributes)->each(function ($data) {
						// Grab and update it
						$productAttribute = ProductAttribute::find($data['id']);
						
						if ($productAttribute) {
							// Mass assignment
							$productAttribute->fill($data);
							
							$productAttribute->save();
							
							ProductAttributeUpdatedEvent::dispatch($productAttribute);
						}
					});
					
					break;
					
				case 'product_attributes.deleted':	
					// Make sure we convert column names to match the model
					$productAttributes = ProductTransformer::transformProductAttributes($cleanedEvent['data']);
					
					collect($productAttributes)->each(function ($data) {
						// Delete it
						$productAttribute = ProductAttribute::find($data['id']);
						
						if ($productAttribute) {
							ProductAttributeDeletedEvent::dispatch($productAttribute);
							
							$productAttribute->delete();
						}
					});
					
					break;
					
				case 'product_vat_rates.added':
					// Make sure we convert column names to match the model
					$productVatRates = ProductTransformer::transformProductVatRates($cleanedEvent['data']);
					
					collect($productVatRates)->each(function ($data) {
						// Insert it
						$productVatRate = ProductVatRate::create($data);
						
						if ($productVatRate) {
							ProductVatRateCreatedEvent::dispatch($productVatRate);
						}
					});
					
					break;
				
				case 'product_vat_rates.updated':
					// Make sure we convert column names to match the model
					$productVatRates = ProductTransformer::transformProductVatRates($cleanedEvent['data']);
					
					collect($productVatRates)->each(function ($data) {
						// Grab and update it
						$productVatRate = ProductVatRate::find($data['id']);
						
						if ($productVatRate) {
							// Mass assignment
							$productVatRate->fill($data);
							
							$productVatRate->save();
							
							ProductVatRateUpdatedEvent::dispatch($productVatRate);
						}
					});
					
					break;
				
				case 'product_vat_rates.deleted':
					// Make sure we convert column names to match the model
					$productVatRates = ProductTransformer::transformProductVatRates($cleanedEvent['data']);
					
					collect($productVatRates)->each(function ($data) {
						// Delete it
						$productVatRate = ProductVatRate::find($data['id']);
						
						if ($productVatRate) {
							ProductVatRateDeletedEvent::dispatch($productVatRate);
							
							$productVatRate->delete();
						}
					});
					
					break;
			}
		}
	}
}
