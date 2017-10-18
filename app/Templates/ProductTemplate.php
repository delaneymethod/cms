<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\{ContentTrait, ProductTrait, CarouselTrait, ProductCategoryTrait, ProductCommodityTrait};

class ProductTemplate extends Template
{
	use ContentTrait, ProductTrait, CarouselTrait, ProductCategoryTrait, ProductCommodityTrait;
	
	protected $view = 'product';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$product = $parameters['product'];
		
		$totalProducts = $this->getProductCount();
		
		$totalProductCommodities = $this->getProductCommodityCount();
		
		$totalProducts = number_format($totalProducts + $totalProductCommodities, 0, '.', ',');
		
		// Check if page has slider
		if (!empty($page->carousel)) {
			$carousel = $this->getCarousel($page->carousel);
			
			if (!empty($carousel->data)) {
				$carousel = json_decode($carousel->data, true);
			
				$images = [];
			
				$contents = [];
			
				foreach ($carousel as $key => $value) {
					if (preg_match('/image/i', $key)) {
						$images[] = $value;
					}
					
					if (preg_match('/content/i', $key)) {
						$contents[] = $value;
					}
				}
				
				$carousel = [];
				
				foreach ($images as $key => $value) {
					array_push($carousel, [
						'image' => $images[$key],
						'content' => $contents[$key],
					]);
				}
	
				$page->carousel = collect($carousel);
			} else {
				$page->carousel = null;
			}
		} else {
			$page->carousel = null;
		}
		
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
