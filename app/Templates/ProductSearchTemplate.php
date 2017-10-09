<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use App\Models\Product;
use Illuminate\View\View;
use App\Http\Traits\{ContentTrait, ProductCategoryTrait};

class ProductSearchTemplate extends Template
{
	use ContentTrait, ProductCategoryTrait;
	
	protected $view = 'productSearch';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$keywords = $parameters['keywords'];
		
		if (!empty($keywords)) {
			$products = Product::search($keywords)->get();
			
			$productCategories = collect([]);
		} else {
			$products = collect([]);
			
			$productCategories = $this->getProductCategories();
			
			// Remove the root
			unset($productCategories[0]);
			
			// Set keys back at zero
			$productCategories = $productCategories->values();
			
			// Grab all top level product categories - ones with parent id = 0, published to the web and sorted
			$productCategories = $productCategories->whereStrict('parent_id', 0)->whereStrict('publish_to_web', 1)->sortBy('sort_order');
		}
		
		$totalProducts = Product::count();
		
		$page->breadcrumbs = collect([]);
		
		$page->breadcrumbs->push([
			'title' => $page->title,
			'slug' => $page->slug,
			'url' => $page->url,
		]);
		
		$page->breadcrumbs->push([
			'title' => 'Search',
			'slug' => 'search',
			'url' => $page->url.'search',
		]);
		
		// Convert inners to objects
		$page->breadcrumbs = $page->breadcrumbs->map(function ($row) {
			return (object) $row;
		});
		
		$page->title = 'Search - '.$page->title;
		
		$page->bannerContent = '<h2>Search '.number_format($totalProducts, 0, '.', ',').' Products</h2>';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'productCategories', 'products', 'keywords'));
	}
}
