<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Illuminate\Http\Request;
use App\Http\Traits\CartTrait;
use App\Http\Traits\PageTrait;
use App\Http\Traits\UserTrait;
use App\Http\Traits\RoleTrait;
use App\Http\Traits\OrderTrait;
use App\Http\Traits\AssetTrait;
use App\Http\Traits\StatusTrait;
use App\Http\Traits\ProductTrait;
use App\Http\Traits\CompanyTrait;
use App\Http\Traits\ArticleTrait;
use App\Http\Traits\LocationTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\TemplateTrait;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	use CartTrait;
	use PageTrait;
	use UserTrait;
	use RoleTrait;
	use OrderTrait;
	use AssetTrait;
	use StatusTrait;
	use ProductTrait;
	use CompanyTrait;
	use ArticleTrait;
	use LocationTrait;
	use CategoryTrait;
	use TemplateTrait;
	
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
   	public function index(Request $request)
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
			$roles = $this->getRoles();
		}
		
		$statuses = $this->getStatuses();
		
		$statCards = [];
		
		if ($currentUser->hasPermission('view_companies')) {
			$companies = $this->getCompanies();
			
			array_push($statCards, [
				'label' => 'Companies',
				'url' => '/cp/companies',
				'count' => $companies->count()
			]);
		}
		
		if ($currentUser->hasPermission('view_users')) {
			$users = $this->getUsers();
			
			array_push($statCards, [
				'label' => 'Users',
				'url' => '/cp/users',
				'count' => $users->count()
			]);
		}
				
		if ($currentUser->hasPermission('view_locations')) {
			$locations = $this->getLocations();
			
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
			
			array_push($statCards, [
				'label' => 'Orders',
				'url' => '/cp/orders',
				'count' => $orders->count()
			]);
		}
				
		if ($currentUser->hasPermission('view_carts')) {
			$carts = $this->getCarts();
			
			array_push($statCards, [
				'label' => 'Carts',
				'url' => '/cp/carts',
				'count' => $carts->count()
			]);	
		}
				
		if ($currentUser->hasPermission('view_categories')) {
			$categories = $this->getCategories();
			
			array_push($statCards, [
				'label' => 'Categories',
				'url' => '/cp/articles/categories',
				'count' => $categories->count()
			]);
		}
				
		if ($currentUser->hasPermission('view_articles')) {
			$articles = $this->getArticles();
			
			array_push($statCards, [
				'label' => 'Articles',
				'url' => '/cp/articles',
				'count' => $articles->count()
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
			$templates = $this->getTemplates();
			
			array_push($statCards, [
				'label' => 'Templates',
				'url' => '/cp/templates',
				'count' => $templates->count()
			]);
		}
				
		if ($currentUser->hasPermission('view_pages')) {
			$pages = $this->getPages();
			
			array_push($statCards, [
				'label' => 'Pages',
				'url' => '/cp/pages',
				'count' => $pages->count()
			]);
		}
		
		if (count($statCards) > 0) {
			$statCards = $this->recursiveObject($statCards);
		}
		
		$orders = [];
		
		if ($currentUser->hasPermission('view_orders')) {
			// Remove Retired, Published, Private, Draft and Suspended
			$statuses->forget([2, 3, 4, 5, 6]);
			
			$orders = [];
			
			$orders['months'] = collect($months)->toArray();
			
			foreach ($months as $month) {
				foreach ($statuses as $status) {
					$orders[str_slug($status->title)][] = [
						'month' => $month->textual,
						'orders' => $this->getOrdersByMonthStatus($month->numeric, $status->id)
					];
				}
			}
			
			$orders = $this->recursiveCollect($orders);
		}
		
		return view('cp.dashboard.index', compact('currentUser', 'title', 'subTitle', 'orders', 'months', 'roles', 'statCards'));
	}
}
