<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Traits\OrderTrait;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
	use OrderTrait;
	
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
	 * Get orders view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_orders')) {
			$title = 'Orders';
		
			$subTitle = $currentUser->company->title;
		
			$orders = $this->getOrders();
		
			return view('cp.orders.index', compact('currentUser', 'title', 'subTitle', 'orders'));
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushOrdersCache() 
	{
		$this->flushCache('orders');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushOrderCache($order) 
	{
		$this->flushCache('orders:id:'.$order->id);
	}
}
