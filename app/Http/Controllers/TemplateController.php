<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Template;
use Illuminate\Http\Request;
use App\Http\Traits\TemplateTrait;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
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
		
		$this->cacheKey = 'templates';
	}
	
	/**
	 * Get templates view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_templates')) {
			$title = 'Templates';
			
			$subTitle = '';
			
			$templates = $this->getCache($this->cacheKey);
			
			if (is_null($templates)) {
				$templates = $this->getTemplates();
				
				$this->setCache($this->cacheKey, $templates);
			}
			
			return view('cp.templates.index', compact('currentUser', 'title', 'subTitle', 'templates'));
		}
		
		abort(403, 'Unauthorised action');
	}
}
