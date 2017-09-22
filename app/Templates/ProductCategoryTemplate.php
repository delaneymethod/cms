<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{ContentTrait, ProductTrait, ProductCategoryTrait};

class ProductCategoryTemplate extends Template
{
	use ContentTrait, ProductTrait, ProductCategoryTrait;
	
	protected $view = 'productCategory';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$productCategory = $parameters['productCategory'];
		
		// Grab all child product categories - ones published to the web and sorted
		$productCategories = $this->getProductCategoriesByParent($productCategory->id);
		
		$productCategories = $productCategories->whereStrict('publish_to_web', 1)->sortBy('sort_order');
		
		// Grab all products - if any - based on business rules, only product categories at the bottom of the chain have products
		$products = $this->getProductsByProductCategory($productCategory->id);
		
		$productAttributeHeadings = null;
		
		if ($products->count() > 0) {
			// Work out all the product attribuet headings
			$productAttributeHeadings = collect([]);
		
			$products->each(function ($product) use ($productAttributeHeadings) {
				$product->product_attributes->each(function ($productAttribute) use ($productAttributeHeadings) {
					$productAttributeHeadings->push($productAttribute->title);
				});
			});
		
			$productAttributeHeadings = $productAttributeHeadings->unique();
		}
		
		$page->breadcrumbs = collect([]);
		
		$page->breadcrumbs->push([
			'title' => $page->title,
			'url' => $page->url,
		]);
		
		// Try to get all product categories based on current product category url.
		$slugs = explode(DIRECTORY_SEPARATOR, $productCategory->url);
		
		// Remove "" and "browse"
		unset($slugs[0], $slugs[1]);
		
		$slugs = collect($slugs);
		
		collect($slugs)->each(function ($slug) use ($page) {
			$parentProductCategory = $this->getProductCategoryBySlug($slug);
			
			// Add each slug
			$page->breadcrumbs->push([
				'title' => $parentProductCategory->title,
				'url' => $parentProductCategory->url,
			]);
		});
		
		// Convert inners to objects
		$page->breadcrumbs = $page->breadcrumbs->map(function ($row) {
			return (object) $row;
		});
		
		$page->title = $productCategory->title;
		
		$page->description = '';
		
		$page->keywords = '';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'productCategory', 'productCategories', 'products', 'productAttributeHeadings'));
	}
}
