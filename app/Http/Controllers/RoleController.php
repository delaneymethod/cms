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
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_roles')) {
			$title = 'Roles';
			
			$subTitle = '';
			
			$roles = $this->getRoles();
			
			return view('cp.advanced.roles.index', compact('currentUser', 'title', 'subTitle', 'roles'));
		}
		
		abort(403, 'Unauthorised action');
	}
	
	/**
     * Creates new permissions.
     *
	 * @params Request 	$request
     * @return Response
     */
    public function permissions(Request $request)
    {
	    $currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_permissions')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedRolesPermissions = $this->sanitizerInput($request->all());
			
			// Creates custom role permission rules as matrix is dynamic
			if (!empty($cleanedRolesPermissions['1'])) {
				$permissions = count($cleanedRolesPermissions['1']) - 1;
			
				foreach (range(0, $permissions) as $index) {
					$rules['1.'.$index] = 'integer';
				}
			}
			
			if (!empty($cleanedRolesPermissions['2'])) {
				$permissions = count($cleanedRolesPermissions['2']) - 1;
			
				foreach (range(0, $permissions) as $index) {
					$rules['2.'.$index] = 'integer';
				}
			}
			
			if (!empty($cleanedRolesPermissions['3'])) {
				$permissions = count($cleanedRolesPermissions['3']) - 1;
				
				foreach (range(0, $permissions) as $index) {
					$rules['3.'.$index] = 'integer';
				}
			}
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedRolesPermissions, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();
			
			try {
				$roles = $this->getRoles();
				
				foreach($roles as $role) {
					if (!empty($cleanedRolesPermissions[$role->id])) {
						$role->setPermissions($cleanedRolesPermissions[$role->id]);
					}
				}	
			} catch (QueryException $queryException) {
				DB::rollback();
			
				Log::info('SQL: '.$queryException->getSql());

				Log::info('Bindings: '.implode(', ', $queryException->getBindings()));

				abort(500, $queryException);
			} catch (Exception $exception) {
				DB::rollback();

				abort(500, $exception);
			}

			DB::commit();

			flash('Changes saved successfully.', $level = 'success');

			return redirect('/cp/advanced/permissions');
		}

		abort(403, 'Unauthorised action');
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
