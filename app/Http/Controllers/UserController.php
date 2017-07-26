<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\User;
use Illuminate\Http\Request;
use App\Http\Traits\RoleTrait;
use App\Http\Traits\UserTrait;
use App\Http\Traits\StatusTrait;
use App\Http\Traits\CompanyTrait;
use App\Http\Traits\LocationTrait;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	use RoleTrait;
	use UserTrait;
	use StatusTrait;
	use CompanyTrait;
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
	 * Get users view.
	 *
	 * @return 	Response
	 */
   	public function index(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('view_users')) {
			$title = 'Users';
		
			$subTitle = $currentUser->company->title;
		
			$users = $this->getUsers();
		
			return view('cp.users.index', compact('currentUser', 'title', 'subTitle', 'users'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for creating a new user.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function create(Request $request)
	{
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_users')) {
			$title = 'Create User';
			
			$subTitle = $currentUser->company->title;
			
			// Used to set company_id
			$companies = $this->getCompanies();
			
			// Used to set role_id
			$roles = $this->getRoles();
			
			// If current user is not a super admin, hide super admin role
			if (!$currentUser->isSuperAdmin()) {
				$roles->forget(0);
			}
			
			// Used to set status_id
			$statuses = $this->getStatuses();
			
			// Used to set location_id
			$locations = $this->getLocations();
			
			return view('cp.users.create', compact('currentUser', 'title', 'subTitle', 'companies', 'statuses', 'locations', 'roles'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Creates a new user.
     *
	 * @params Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
	    $currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission('create_users')) {
			// Remove any Cross-site scripting (XSS)
			$cleanedUser = $this->sanitizerInput($request->all());

			$rules = $this->getRules('user');
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedUser, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			DB::beginTransaction();

			try {
				// Create new model
				$user = new User;
	
				// Set our field data
				$user->first_name = $cleanedUser['first_name'];
				$user->last_name = $cleanedUser['last_name'];
				$user->email = $cleanedUser['email'];
				$user->password = bcrypt($cleanedUser['password']);
				$user->telephone = $cleanedUser['telephone'];
				$user->mobile = $cleanedUser['mobile'];
				$user->job_title = $cleanedUser['job_title'];
				$user->company_id = $cleanedUser['company_id'];
				$user->location_id = $cleanedUser['location_id'];
				$user->status_id = $cleanedUser['status_id'];
				$user->role_id = $cleanedUser['role_id'];
				
				$user->save();
				
				$user->setRole($user->role_id);
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

			flash('User created successfully.', $level = 'success');

			return redirect('/cp/users');
		}

		abort(403, 'Unauthorised action');
    }
    
    /**
	 * Shows a form for editing a user.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function edit(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('edit_users') || $currentUser->id == $id) {
			$title = 'Edit User';
		
			$subTitle = $currentUser->company->title;
			
			$user = $this->getUser($id);
			
			$this->authorize('userOwnsThis', $user);
			
			// Used to set company_id
			$companies = $this->getCompanies();
		
			// Used to set role_id
			$roles = $this->getRoles();
			
			// If current user is not a super admin, hide super admin role
			if (!$currentUser->isSuperAdmin()) {
				$roles->forget(0);
			}
			
			// Used to set status_id
			$statuses = $this->getStatuses();
		
			// Used to set location_id
			$locations = $this->getLocations();
		
			return view('cp.users.edit.index', compact('currentUser', 'title', 'subTitle', 'user', 'companies', 'roles', 'statuses', 'locations'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for editing a user password.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function editPassword(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('edit_passwords_users') || $currentUser->id == $id) {
			$title = 'Change Password';
			
			$subTitle = $currentUser->company->title;
			
			$user = $this->getUser($id);
			
			$this->authorize('userOwnsThis', $user);
			
			return view('cp.users.edit.password', compact('currentUser', 'title', 'subTitle', 'user'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Updates a specific user.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function update(Request $request, int $id)
	{
		$permission = 'edit_users';
		
		$updatePassword = false;
		
		if ($request->get('password_confirmation')) {
			$updatePassword = true;
		}
		
		// User is changing password so add "on the fly" permissions
		if ($updatePassword) {
			$permission = 'edit_passwords_users';
		}
			
		$currentUser = $this->getAuthenticatedUser();

		if ($currentUser->hasPermission($permission) || $currentUser->id == $id) {
			// Remove any Cross-site scripting (XSS)
			$cleanedUser = $this->sanitizerInput($request->all());

			$rules = $this->getRules('user');
			
			$rules['email'] = 'required|email|unique:users,email,'.$id.'|max:255';
			
			// User is changing password so add "on the fly" rule
			if ($updatePassword) {
				$rules['password_confirmation'] = 'required|string|same:password|max:255';
			}
			
			// Make sure all the input data is what we actually save
			$validator = $this->validatorInput($cleanedUser, $rules);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			
			DB::beginTransaction();

			try {
				// Create new model
				$user = $this->getUser($id);
				
				$this->authorize('userOwnsThis', $user);
		
				// Set our field data
				$user->first_name = $cleanedUser['first_name'];
				$user->last_name = $cleanedUser['last_name'];
				$user->email = $cleanedUser['email'];
				
				if ($updatePassword) {
					$user->password = bcrypt($cleanedUser['password_confirmation']);
				} else {
					$user->password = $cleanedUser['password'];
				}
				
				$user->job_title = $cleanedUser['job_title'];
				$user->telephone = $cleanedUser['telephone'];
				$user->mobile = $cleanedUser['mobile'];
				$user->company_id = $cleanedUser['company_id'];
				$user->location_id = $cleanedUser['location_id'];
				$user->status_id = $cleanedUser['status_id'];
				$user->role_id = $cleanedUser['role_id'];
				$user->updated_at = $this->datetime;
				
				$user->save();
				
				$user->setRole($user->role_id);
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

			flash('User updated successfully.', $level = 'success');

			return redirect('/cp/users');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Retires a specific user.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function retire(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('retire_users')) {
			$user = $this->getUser($id);
				
			$this->authorize('userOwnsThis', $user);
		
			if ($currentUser->id == $user->id) {
				flash('You cannot retire yourself.', $level = 'warning');

				return redirect('/cp/users');
			}
			
			DB::beginTransaction();

			try {
				// Retired status
				$user->status_id = 3;
				$user->updated_at = $this->datetime;
				
				$user->save();
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

			flash('User retired successfully.', $level = 'info');

			return redirect('/cp/users');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for deleting a user.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function confirm(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_users')) {
			$user = $this->getUser($id);
		
			$this->authorize('userOwnsThis', $user);
			
			if ($currentUser->id == $user->id) {
				flash('You cannot delete yourself.', $level = 'warning');
	
				return redirect('/cp/users');
			}
			
			$title = 'Delete User';
			
			$subTitle = $currentUser->company->title;
			
			return view('cp.users.delete', compact('currentUser', 'title', 'subTitle', 'user'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Deletes a specific user.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function delete(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('delete_users')) {
			$user = $this->getUser($id);
			
			$this->authorize('userOwnsThis', $user);
			
			if ($currentUser->id == $user->id) {
				flash('You cannot delete yourself.', $level = 'warning');

				return redirect('/cp/users');
			}
		
			DB::beginTransaction();

			try {
				$user->delete();
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

			flash('User deleted successfully.', $level = 'info');

			return redirect('/cp/users');
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushUsersCache()
	{
		$this->flushCache('users');	
	}
	
	/**
	 * Does what it says on the tin!
	 */
	public function flushUserCache($user)
	{
		$this->flushCache('users:id:'.$user->id);
		
		$this->flushCache('users:email:'.$user->email);
		
		$this->flushCache('users:role:id:'.$user->role_id);
	}
}
