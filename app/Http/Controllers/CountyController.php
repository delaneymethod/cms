<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\County;
use Illuminate\Http\Request;
use App\Http\Traits\CountyTrait;
use App\Http\Controllers\Controller;

class CountyController extends Controller
{
	use CountyTrait;

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
	 * Does what it says on the tin!
	 */
	public function flushCountiesCache() 
	{
		$this->flushCache('counties');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushCountyCache($county) 
	{
		$this->flushCache('counties:id:'.$county->id);
	}
}
