<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\ContentTrait;

class HomepageTemplate extends Template
{
	use ContentTrait;

	protected $view = 'homepage';
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$page->breadcrumbs = collect([]);
		
		$page->breadcrumbs->push([
			'title' => $page->title,
			'slug' => $page->slug,
			'url' => $page->url,
		]);
		
		// Convert inners to objects
		$page->breadcrumbs = $page->breadcrumbs->map(function ($row) {
			return (object) $row;
		});
		
		$page->bannerImage = 'https://www.grampianfasteners.com/files/1680c433-741e-4778-8522-0dcc6545d33f/bg_rigs_1_edit_darker.jpg';
		
		$page->bannerMessage = '
			<h2>We make your connections simple</h2>
			<h4>Imagine one place for everything you need to connect your equipment.</h4>
			<h4>We have a huge range of fasteners and tools to make the connections in stock.</h4>
		';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart'));
	}
}
