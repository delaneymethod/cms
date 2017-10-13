<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\ContentTrait;

class ProductManufacturerTemplate extends Template
{
	use ContentTrait;
	
	protected $view = 'productManufacturer';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$productManufacturer = $parameters['productManufacturer'];
		
		$page->breadcrumbs = collect([]);
		
		$page->breadcrumbs->push([
			'title' => $page->title,
			'slug' => $page->slug,
			'url' => $page->url,
		]);
		
		// Add article itself to the list
		$page->breadcrumbs->push([
			'title' => $productManufacturer->title,
			'slug' => $productManufacturer->slug,
			'url' => $productManufacturer->url,
		]);
		
		// Convert inners to objects
		$page->breadcrumbs = $page->breadcrumbs->map(function ($row) {
			return (object) $row;
		});
		
		$page->title = $productManufacturer->title.' - '.$page->title;
		
		$page->bannerContent = '<h2>'.$productManufacturer->title.'</h2>';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart', 'productManufacturer'));
	}
}
