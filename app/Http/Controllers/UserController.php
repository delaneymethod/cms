<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\User;
use Illuminate\Http\Request;
use App\Http\Traits\RoleTrait;
use App\Http\Traits\UserTrait;
use App\Http\Traits\StatusTrait;
use App\Http\Traits\LocationTrait;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	use RoleTrait;
	use UserTrait;
	use StatusTrait;
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
		$title = 'Users';
		
		$subTitle = '';
		
		$users = $this->getUsers();
		
		return view('cp.users.index', compact('title', 'subTitle', 'users'));
	}
	
	/**
	 * Shows a form for creating a new user.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function create(Request $request)
	{
		$title = 'Create User';
		
		$subTitle = 'Users';
		
		// Used to set role_id
		$roles = $this->getRoles();
		
		// Used to set status_id
		$statuses = $this->getStatuses();
		
		// Used to set status_id
		$locations = $this->getLocations();
		
		return view('cp.users.create', compact('title', 'subTitle', 'statuses', 'locations', 'roles'));
	}
	
	/**
     * Creates a new user.
     *
	 * @params	Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
	    //$currentUser = $this->getAuthenticatedUser();

		//if ($currentUser->hasPermission('create_users')) {
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
				$user->location_id = $cleanedUser['location_id'];
				$user->status_id = $cleanedUser['status_id'];
				$user->role_id = $cleanedUser['role_id'];
				
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

			flash('User created successfully.', $level = 'success');

			return redirect('/cp/users');
		//}

		//abort(403, 'Unauthorised action');
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
		$title = 'Edit User';
		
		$subTitle = 'Users';
		
		$user = $this->getUser($id);
		
		// Used to set role_id
		$roles = $this->getRoles();
		
		// Used to set status_id
		$statuses = $this->getStatuses();
		
		// Remove the retire status from the list since we are updating the current user
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->id == $id) {
			$statuses->forget(2);
		}
		
		// Used to set status_id
		$locations = $this->getLocations();
		
		return view('cp.users.edit.index', compact('title', 'subTitle', 'user', 'roles', 'statuses', 'locations'));
	}
	
	/**
	 * Shows a form for editing a user.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function editPassword(Request $request, int $id)
	{
		$title = 'Change Password';
		
		$subTitle = 'Users';
		
		$user = $this->getUser($id);
		
		return view('cp.users.edit.password', compact('title', 'subTitle', 'user'));
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
			
		//$currentUser = $this->getAuthenticatedUser();

		//if ($currentUser->hasPermission($permission)) {
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
		//}

		//abort(403, 'Unauthorised action');
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
		
		if ($currentUser->id == $id) {
			flash('You cannot retire yourself.', $level = 'warning');

			return redirect('/cp/users');
		}
		
		//if ($currentUser->hasPermission('retire_users')) {
			DB::beginTransaction();

			try {
				$user = $this->getUser($id);
				
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
		//}

		//abort(403, 'Unauthorised action');
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
		
		if ($currentUser->id == $id) {
			flash('You cannot delete yourself.', $level = 'warning');

			return redirect('/cp/users');
		}
		
		$title = 'Delete User';
		
		$subTitle = 'Users';
	
		$user = $this->getUser($id);
		
		return view('cp.users.delete', compact('title', 'subTitle', 'user'));
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

		if ($currentUser->id == $id) {
			flash('You cannot delete yourself.', $level = 'warning');

			return redirect('/cp/users');
		}
		
		//if ($currentUser->hasPermission('delete_users')) {
			DB::beginTransaction();

			try {
				$user = $this->getUser($id);
				
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
		//}

		//abort(403, 'Unauthorised action');
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
