<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Traits\PageTrait;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
	use PageTrait;
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('guest');
	}

	/**
	 * Get home view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		$page = $this->getPage(1);
		
		return view('index', compact('currentUser', 'page'));
	}
}
