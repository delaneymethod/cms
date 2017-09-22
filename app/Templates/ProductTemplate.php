<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{ContentTrait, ProductCategoryTrait};

class ProductTemplate extends Template
{
	use ContentTrait, ProductCategoryTrait;
	
	protected $view = 'product';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$product = $parameters['product'];
		
		$page->breadcrumbs = collect([]);
		
		$page->breadcrumbs->push([
			'title' => $page->title,
			'url' => $page->url,
		]);
		
		// Try to get all product categories based on current products product category url.
		$slugs = explode(DIRECTORY_SEPARATOR, $product->product_category->url);
		
		// Remove "" and "browse"
		unset($slugs[0], $slugs[1]);
		
		$slugs = collect($slugs);
		
		collect($slugs)->each(function ($slug) use ($page) {
			$productCategory = $this->getProductCategoryBySlug($slug);
			
			// Add each slug
			$page->breadcrumbs->push([
				'title' => $productCategory->title,
				'url' => $productCategory->url,
			]);
		});
		
		// Add product itself to the list
		$page->breadcrumbs->push([
			'title' => $product->title,
			'url' => $product->url,
		]);
		
		// Convert inners to objects
		$page->breadcrumbs = $page->breadcrumbs->map(function ($row) {
			return (object) $row;
		});
		
		$page->title = $product->title;
		
		$page->description = '';
		
		$page->keywords = '';
			
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'product'));
	}
}
