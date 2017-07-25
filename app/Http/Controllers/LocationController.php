<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Traits\LocationTrait;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
	use LocationTrait;

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
	 * Get locations view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		$title = 'Locations';
		
		$subTitle = $currentUser->company->title;
		
		$locations = $this->getLocations();
		
		return view('cp.locations.index', compact('title', 'subTitle', 'locations'));
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushLocationsCache()
	{
		$this->flushCache('locations');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushLocationCache($location)
	{
		$this->flushCache('locations:id:'.$location->id);
	}
}
