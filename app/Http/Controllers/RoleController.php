<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Traits\RoleTrait;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
	use RoleTrait;

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
	 * Get roles view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$title = 'Roles';
		
		$subTitle = '';
		
		$roles = $this->getRoles();
		
		return view('cp.advanced.roles.index', compact('title', 'subTitle', 'roles'));
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushRolesCache()
	{
		$this->flushCache('roles');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushRoleCache($role)
	{
		$this->flushCache('roles:id:'.$role->id);
	}
}
