<?php
namespace App\Templates;

use Illuminate\View\View;
use App\Http\Traits\ContentTrait;

class HomepageTemplate extends Template
{
	use ContentTrait;

	protected $view = 'homepage';

	public function __construct()
	{
	}
	
	public function prepare(View $view, array $parameters)
	{
		$currentUser = $parameters['currentUser'];
		
		$page = $this->getPageContent($parameters['page']);
		
		$cart = $parameters['cart'];
		
		$wishlistCart = $parameters['wishlistCart'];
		
		$view->with(compact('currentUser', 'page', 'cart', 'wishlistCart'));
	}
}
