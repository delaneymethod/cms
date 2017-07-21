<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Traits\StatusTrait;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
	use StatusTrait;

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
	 * Get statuses view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$title = 'Statuses';
		
		$subTitle = '';
		
		$statuses = $this->getStatuses();
		
		return view('cp.advanced.statuses.index', compact('title', 'subTitle', 'statuses'));
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushStatusesCache()
	{
		$this->flushCache('statuses');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushStatusCache($status)
	{
		$this->flushCache('statuses:id:'.$status->id);
	}
}
