<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{ContentTrait, ProductTrait, ProductCategoryTrait};

class ProductTemplate extends Template
{
	use ContentTrait, ProductTrait, ProductCategoryTrait;
	
	protected $view = 'product';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$product = $parameters['product'];
		
		$totalProducts = number_format($this->getProducts()->count(), 0, '.', ',');
		
		$page->breadcrumbs = collect([]);
		
		$page->breadcrumbs->push([
			'title' => $page->title,
			'slug' => $page->slug,
			'url' => $page->url,
		]);
		
		// Try to get all product categories based on current products product category url.
		$slugs = explode(DIRECTORY_SEPARATOR, $product->product_category->url);
		
		// Remove ""
		unset($slugs[0], $slugs[1]);
		
		$slugs = collect($slugs);
		
		collect($slugs)->each(function ($slug) use ($page) {
			$productCategory = $this->getProductCategoryBySlug($slug);
			
			// Add each slug
			$page->breadcrumbs->push([
				'title' => $productCategory->title,
				'slug' => $productCategory->slug,
				'url' => $productCategory->url,
			]);
		});
		
		// Add product itself to the list
		$page->breadcrumbs->push([
			'title' => $product->title,
			'slug' => $product->slug,
			'url' => $product->url,
		]);
		
		// Convert inners to objects
		$page->breadcrumbs = $page->breadcrumbs->map(function ($row) {
			return (object) $row;
		});
		
		$page->title = $product->title;
			
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'product', 'totalProducts'));
	}
}
