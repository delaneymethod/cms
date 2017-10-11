<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{ContentTrait, ProductTrait, ProductCategoryTrait, ProductCommodityTrait};

class ProductsTemplate extends Template
{
	use ContentTrait, ProductTrait, ProductCategoryTrait, ProductCommodityTrait;
	
	protected $view = 'products';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$productCategories = $this->getProductCategories();
		
		// Remove the root
		unset($productCategories[0]);
		
		// Set keys back at zero
		$productCategories = $productCategories->values();
		
		// Grab all top level product categories - ones with parent id = 0, published to the web and sorted
		$productCategories = $productCategories->whereStrict('parent_id', 0)->whereStrict('publish_to_web', 1)->sortBy('sort_order');
		
		$totalProducts = $this->getProductCount();
		
		$totalProductCommodities = $this->getProductCommodityCount();
		
		$totalProducts = number_format($totalProducts + $totalProductCommodities, 0, '.', ',');
		
		$page->breadcrumbs = collect([]);
		
		$page->breadcrumbs->push([
			'title' => $page->title,
			'slug' => $page->slug,
			'url' => $page->url,
		]);
		
		$page->breadcrumbs = $page->breadcrumbs->map(function ($row) {
			return (object) $row;
		});
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'productCategories', 'totalProducts'));
	}
}
