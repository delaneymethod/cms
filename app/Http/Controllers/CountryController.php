<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Traits\CountryTrait;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
	use CountryTrait;

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
	public function flushCountriesCache() 
	{
		$this->flushCache('countries');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushCountryCache($country) 
	{
		$this->flushCache('countries:id:'.$country->id);
	}
}
