<?php
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\ContentTrait;

class PageTemplate extends Template
{
	use ContentTrait;
	
	protected $view = 'page';

	public function __construct()
	{
	}
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$page->description = '';
		
		$page->keywords = '';
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart'));
	}
}
