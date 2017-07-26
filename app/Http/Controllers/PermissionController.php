<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Traits\PermissionTrait;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
	use PermissionTrait;

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
	 * Get permissions view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_permissions')) {
			$title = 'Permissions';
			
			$subTitle = '';
			
			$permissions = $this->getPermissions();
			
			return view('cp.advanced.permissions.index', compact('currentUser', 'title', 'subTitle', 'permissions'));
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushPermissionsCache()
	{
		$this->flushCache('permissions');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushPermissionCache($permission)
	{
		$this->flushCache('permissions:id:'.$permission->id);
	}
}
