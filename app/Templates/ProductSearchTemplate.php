<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;
use App\Models\{Product, ProductCommodity};
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
			$productCommodities = ProductCommodity::search($keywords)->get();
			
			$products = Product::search($keywords)->get();
			
			$productCategories = collect([]);
		} else {
			$productCommodities = collect([]);
			
			$products = collect([]);
			
			$productCategories = $this->getProductCategories();
			
			// Remove the root
			unset($productCategories[0]);
			
			// Set keys back at zero
			$productCategories = $productCategories->values();
			
			// Grab all top level product categories - ones with parent id = 0, published to the web and sorted
			$productCategories = $productCategories->whereStrict('parent_id', 0)->whereStrict('publish_to_web', 1)->sortBy('sort_order');
		}
		
		$totalFound = $products->count() + $productCommodities->count();
		
		$totalFoundPretty = number_format($totalFound, 0, '.', ',');
		
		$totalProducts = Product::count();
		
		$totalProductCommodities = ProductCommodity::count();
		
		$totalProducts = number_format($totalProducts + $totalProductCommodities, 0, '.', ',');
		
		$page->breadcrumbs = collect([]);
		
		$page->breadcrumbs->push([
			'title' => $page->title,
			'slug' => $page->slug,
			'url' => $page->url,
		]);
		
		$page->breadcrumbs->push([
			'title' => 'Search',
			'slug' => 'search',
			'url' => '/products/search',
		]);
		
		// Convert inners to objects
		$page->breadcrumbs = $page->breadcrumbs->map(function ($row) {
			return (object) $row;
		});
		
		$page->title = 'Search - '.$page->title;
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'productCategories', 'productCommodities', 'products', 'keywords', 'totalFound', 'totalFoundPretty', 'totalProducts'));
	}
}
