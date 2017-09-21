<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Controllers;

use DB;
use Log;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\{CartTrait, PageTrait, UserTrait, RoleTrait, OrderTrait, AssetTrait, StatusTrait, ProductTrait, CompanyTrait, ArticleTrait, LocationTrait, TemplateTrait, ArticleCategoryTrait};

class DashboardController extends Controller
{
	use CartTrait, PageTrait, UserTrait, RoleTrait, OrderTrait, AssetTrait, StatusTrait, ProductTrait, CompanyTrait, ArticleTrait, LocationTrait, TemplateTrait, ArticleCategoryTrait;
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('auth');
	}

	/**
	 * Get cp view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request) : View
	{
		$currentUser = $this->getAuthenticatedUser();
		
		$title = 'Dashboard';
		
		$subTitle = $currentUser->company->title;
		
		$months = [];
			
		for ($i = 0; $i < 6; $i++) {
			array_push($months, [
				'textual' => date('F', strtotime('-'.$i.' month')),
				'numeric' => date('n', strtotime('-'.$i.' month'))
			]);
		}
		
		$months = $this->recursiveObject($months);
		
		$roles = [];
		
		if ($currentUser->hasPermission('view_roles')) {
			$roles = $this->getData('getRoles', 'roles');
		}
		
		$statuses = $this->getData('getStatuses', 'statuses');
		
		$statCards = [];
		
		if ($currentUser->hasPermission('view_companies')) {
			$companies = $this->getData('getCompanies', 'companies');
			
			array_push($statCards, [
				'label' => 'Companies',
				'url' => '/cp/companies',
				'count' => $companies->count()
			]);
		}
		
		if ($currentUser->hasPermission('view_users')) {
			$users = $this->getData('getUsers', 'users');
			
			array_push($statCards, [
				'label' => 'Users',
				'url' => '/cp/users',
				'count' => $users->count()
			]);
			
			array_push($statCards, [
				'label' => 'Messages',
				'url' => '/cp/users/'.$currentUser->id.'/notifications',
				'count' => $currentUser->notifications->count()
			]);
		}
				
		if ($currentUser->hasPermission('view_locations')) {
			$locations = $this->getData('getLocations', 'locations');
			
			array_push($statCards, [
				'label' => 'Locations',
				'url' => '/cp/locations',
				'count' => $locations->count()
			]);
		}
				
		if ($currentUser->hasPermission('view_products')) {
			$products = $this->getProducts();
			
			array_push($statCards, [
				'label' => 'Products',
				'url' => '/cp/products',
				'count' => $products->count()
			]);
		}
				
		if ($currentUser->hasPermission('view_orders')) {
			$orders = $this->getOrders();
			
			// Now pull in the orders status data since we'll be using this broadcast to update some UI's
			foreach ($orders as $order) {
				$order->load('status');
			}
			
			array_push($statCards, [
				'label' => 'Orders',
				'url' => '/cp/orders',
				'count' => $orders->count()
			]);
			
			$orderStats = [];
		
			foreach ($months as $month) {
				array_push($orderStats, [
					'month' => $month->textual,
					'total' => $this->getOrdersByMonth($month->numeric)->count(),
				]);
			}
			
			$orderStats = recursiveCollect($orderStats);
		}
				
		if ($currentUser->hasPermission('view_carts')) {
			$carts = $this->getCarts();
			
			array_push($statCards, [
				'label' => 'Carts',
				'url' => '/cp/carts',
				'count' => $carts->count()
			]);	
		}
				
		if ($currentUser->hasPermission('view_articles')) {
			$articles = $this->getData('getArticles', 'articles');
			
			array_push($statCards, [
				'label' => 'Articles',
				'url' => '/cp/articles',
				'count' => $articles->count()
			]);
		}
		
		if ($currentUser->hasPermission('view_article_categories')) {
			$articleCategories = $this->getData('getArticleCategories', 'article_categories');
			
			array_push($statCards, [
				'label' => 'Article Categories',
				'url' => '/cp/articles/categories',
				'count' => $articleCategories->count()
			]);
		}
				
		if ($currentUser->hasPermission('view_assets')) {
			$assets = $this->getAssets();
			
			array_push($statCards, [
				'label' => 'Assets',
				'url' => '/cp/assets',
				'count' => $assets->count()
			]);
		}
				
		if ($currentUser->hasPermission('view_templates')) {
			$templates = $this->getData('getTemplates', 'templates');
			
			array_push($statCards, [
				'label' => 'Templates',
				'url' => '/cp/templates',
				'count' => $templates->count()
			]);
		}
				
		if ($currentUser->hasPermission('view_pages')) {
			$pages = $this->getData('getPages', 'pages');
			
			array_push($statCards, [
				'label' => 'Pages',
				'url' => '/cp/pages',
				'count' => $pages->count()
			]);
		}
		
		if (count($statCards) > 0) {
			$statCards = $this->recursiveObject($statCards);
		}
		
		return view('cp.dashboard.index', compact('currentUser', 'title', 'subTitle', 'orders', 'orderStats', 'months', 'roles', 'statCards'));
	}
}
