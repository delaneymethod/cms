<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Illuminate\Http\Request;

use App\Http\Traits\RoleTrait;
use App\Http\Traits\PageTrait;
use App\Http\Traits\UserTrait;
use App\Http\Traits\OrderTrait;
use App\Http\Traits\AssetTrait;
use App\Http\Traits\CompanyTrait;
use App\Http\Traits\ArticleTrait;
use App\Http\Traits\LocationTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	use RoleTrait;
	use PageTrait;
	use UserTrait;
	use OrderTrait;
	use AssetTrait;
	use CompanyTrait;
	use ArticleTrait;
	use LocationTrait;
	use CategoryTrait;
	
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
		
		$categories = $this->getCategories();
		
		$roles = $this->getRoles();
		
		$pages = $this->getPages();
		
		$users = $this->getUsers();
		
		$orders = $this->getOrders();
		
		$assets = $this->getAssets();
		
		$companies = $this->getCompanies();
		
		$articles = $this->getArticles();
		
		$locations = $this->getLocations();
		
		return view('cp.dashboard.index', compact('currentUser', 'title', 'subTitle', 'categories', 'roles', 'pages', 'users', 'orders', 'assets', 'companies', 'articles', 'locations'));
	}
}
