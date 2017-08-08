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
			
			$templates = $this->getTemplates();
			
			return view('cp.templates.index', compact('currentUser', 'title', 'subTitle', 'templates'));
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushTemplatesCache()
	{
		$this->flushCache('templates');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushTemplateCache($template)
	{
		$this->flushCache('templates:id:'.$template->id);
	}
}
