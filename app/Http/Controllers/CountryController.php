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
}
