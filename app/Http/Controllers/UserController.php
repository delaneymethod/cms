<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Controllers;

use DB;
use Log;
use App\User;
use Exception;
use Carbon\Carbon;
use App\Jobs\ProcessUserJob;
use Illuminate\Http\Request;
use App\Events\UserUpdatedEvent;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Password;
use App\Http\Traits\{RoleTrait, UserTrait, StatusTrait, CompanyTrait, LocationTrait, NotificationTrait};

class UserController extends Controller
{	
	use RoleTrait, UserTrait, StatusTrait, CompanyTrait, LocationTrait, NotificationTrait;
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware('auth', [
			'except' => [
				'webhook'
			]
		]);
		
		$this->cacheKey = 'users';
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
			
			$users = $this->getCache($this->cacheKey);
			
			if (is_null($users)) {
				$users = $this->getUsers();
				
				$users = $this->filterUsers($users);
				
				$this->setCache($this->cacheKey, $users);
			}
			
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
			$companies = $this->getData('getCompanies', 'companies');
			
			$companies = $this->filterCompanies($companies);
			
			// Used to set role_id
			$roles = $this->getData('getRoles', 'roles');
			
			// If current user is not a super admin, hide super admin role
			if (!$currentUser->isSuperAdmin()) {
				$roles->forget(0);
			}
			
			// Used to set status_id
			$statuses = $this->getData('getStatuses', 'statuses');
			
			// Remove Published, Private, Draft, Suspended, Shipped and Delivered keys
			$statuses->forget([3, 4, 5, 6, 7, 8]);
			
			// Used to set location_id
			if ($companies->count() > 1) {
				$locations = $companies->map(function($company) {
					return $company->locations;	
				})->flatten();
			} else {
				$locations = $companies->first()->locations;
			}
			
			$defaultLocationIds = $this->getDefaultLocationIds();
			
			return view('cp.users.create', compact('currentUser', 'title', 'subTitle', 'companies', 'statuses', 'locations', 'roles', 'defaultLocationIds'));
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
				$user->solution_id = $cleanedUser['solution_id'];
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
				$user->receive_emails = (isset($cleanedUser['receive_emails'])) ? $cleanedUser['receive_emails'] : 0;
				$user->receive_notifications = (isset($cleanedUser['receive_notifications'])) ? $cleanedUser['receive_notifications'] : 0;
				
				$user->save();
				
				// Allows user to set a password
				Password::sendResetLink(['email' => $user->email]);
				
				$users = $this->getUsers();
				
				$users = $this->filterUsers($users);
				
				$this->setCache($this->cacheKey, $users);
				
				$minutes = config('cms.delays.jobs');
					
				$time = Carbon::now()->addMinutes($minutes);
				
				// Dispatches a new job to process the user. Sticks the job in the "users" queue to run in 10 minutes.
				ProcessUserJob::dispatch($user, 'users.created')->delay($time)->onQueue('users.jobs');
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
			$companies = $this->getData('getCompanies', 'companies');
		
			$companies = $this->filterCompanies($companies);
			
			// Used to set role_id
			$roles = $this->getData('getRoles', 'roles');
			
			// If current user is not a super admin, hide super admin role
			if (!$currentUser->isSuperAdmin()) {
				$roles->forget(0);
			}
			
			// Used to set status_id
			$statuses = $this->getData('getStatuses', 'statuses');
			
			// Remove Published, Private, Draft, Suspended, Shipped and Delivered keys
			$statuses->forget([3, 4, 5, 6, 7, 8]);
			
			// Used to set location_id
			if ($companies->count() > 1) {
				$locations = $companies->map(function($company) {
					return $company->locations;	
				})->flatten();
			} else {
				$locations = $companies->first()->locations;
			}
			
			$defaultLocationIds = $this->getDefaultLocationIds();
			
			return view('cp.users.edit.index', compact('currentUser', 'title', 'subTitle', 'user', 'companies', 'roles', 'statuses', 'locations'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Shows a form for editing a users password.
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
	 * Shows a form for editing a users settings.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function editSettings(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission('edit_settings_users') || $currentUser->id == $id) {
			$title = 'Settings';
			
			$subTitle = $currentUser->company->title;
			
			$user = $this->getUser($id);
			
			$this->authorize('userOwnsThis', $user);
			
			return view('cp.users.edit.settings', compact('currentUser', 'title', 'subTitle', 'user'));
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
		
		$updateSettings = false;
		
		if ($request->get('password_confirmation')) {
			$updatePassword = true;
		}
		
		if ($request->get('settings')) {
			$updateSettings = true;
		}
		
		// User is changing password so add "on the fly" permissions
		if ($updatePassword) {
			$permission = 'edit_passwords_users';
		}
		
		// User is changing password so add "on the fly" permissions
		if ($updateSettings) {
			$permission = 'edit_settings_users';
		}
			
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->hasPermission($permission) || $currentUser->id == $id) {
			// Remove any Cross-site scripting (XSS)
			$cleanedUser = $this->sanitizerInput($request->all());
			
			$rules = $this->getRules('user');
			
			// User is changing password so add "on the fly" rule
			if ($updatePassword) {
				$rules = [];
				
				$rules['password_confirmation'] = 'required|string|same:password|max:255';
			} else if ($updateSettings) {
				$rules = [];
				
				$rules['receive_emails'] = 'integer';
				$rules['receive_notifications'] = 'integer';	
			} else {
				$rules['email'] = 'required|email|unique:users,email,'.$id.'|max:255';
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
				if ($updatePassword) {
					$user->password = bcrypt($cleanedUser['password_confirmation']);
				} else if ($updateSettings) {
					$user->receive_emails = (isset($cleanedUser['receive_emails'])) ? $cleanedUser['receive_emails'] : 0;
					$user->receive_notifications = (isset($cleanedUser['receive_notifications'])) ? $cleanedUser['receive_notifications'] : 0;
				} else {
					$user->solution_id = $cleanedUser['solution_id'];
					$user->first_name = $cleanedUser['first_name'];
					$user->last_name = $cleanedUser['last_name'];
					$user->email = $cleanedUser['email'];
					$user->password = $cleanedUser['password'];
					$user->job_title = $cleanedUser['job_title'];
					$user->telephone = $cleanedUser['telephone'];
					$user->mobile = $cleanedUser['mobile'];
					$user->company_id = $cleanedUser['company_id'];
					$user->location_id = $cleanedUser['location_id'];
					$user->status_id = $cleanedUser['status_id'];
					$user->role_id = $cleanedUser['role_id'];
				}
								
				$user->updated_at = $this->datetime;
				
				$user->save();
				
				$users = $this->getUsers();
				
				$users = $this->filterUsers($users);
				
				$this->setCache($this->cacheKey, $users);
				
				$minutes = config('cms.delays.jobs');
					
				$time = Carbon::now()->addMinutes($minutes);
				
				// Dispatches a new job to process the user. Sticks the job in the "users" queue to run in 10 minutes.
				ProcessUserJob::dispatch($user, 'users.updated')->delay($time)->onQueue('users.jobs');
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
			
			// This will only be the case if the user has requested to edit their details fron the checkout page
			$redirectTo = $request->get('redirectTo');

			if (!empty($redirectTo)) {
				return redirect($redirectTo);
			}
		
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
				$status = $this->getStatusByTitle('Retired');
				
				$user->status_id = $status->id;
				$user->updated_at = $this->datetime;
				
				$user->save();
				
				$users = $this->getUsers();
				
				$users = $this->filterUsers($users);
				
				$this->setCache($this->cacheKey, $users);
				
				$minutes = config('cms.delays.jobs');
					
				$time = Carbon::now()->addMinutes($minutes);
				
				// Dispatches a new job to process the user. Sticks the job in the "users" queue to run in 10 minutes.
				ProcessUserJob::dispatch($user, 'users.updated')->delay($time)->onQueue('users.jobs');
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
				$minutes = config('cms.delays.jobs');
					
				$time = Carbon::now()->addMinutes($minutes);
				
				// Dispatches a new job to process the user. Sticks the job in the "users" queue to run in 10 minutes.
				ProcessUserJob::dispatch($user, 'users.deleted')->delay($time)->onQueue('users.jobs');
				
				$user->delete();
				
				$users = $this->getUsers();
				
				$users = $this->filterUsers($users);
				
				$this->setCache($this->cacheKey, $users);
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
	 * Gets notifications view for current user.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function notifications(Request $request, int $id)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->id == $id) {
			$title = 'Messages';
			
			$subTitle = $currentUser->company->title;
			
			$notifications = $currentUser->notifications;
			
			foreach ($notifications as $notification) {
				$notification->subject = str_replace(['App\Notifications\OrderUpdatedNotification', 'App\Notifications\OrderCreatedNotification'], ['Order Updated', 'Order Created'], $notification->type);
			}
			
			return view('cp.users.notifications.index', compact('currentUser', 'title', 'subTitle', 'notifications'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
	 * Gets specified notification view for current user.
	 *
	 * @params	Request 	$request
	 * @param	int			$id
	 * @return 	Response
	 */
   	public function notification(Request $request, int $id, string $uuid)
	{
		$currentUser = $this->getAuthenticatedUser();
		
		if ($currentUser->id == $id) {
			$notification = $this->getNotification($uuid);
			
			// Set a subject
			$notification->subject = str_replace(['App\Notifications\OrderUpdatedNotification', 'App\Notifications\OrderCreatedNotification'], ['Order Updated', 'Order Created'], $notification->type);
			
			$title = $notification->subject;
			
			$subTitle = 'Messages';
			
			// Mark it as read...
			$currentUser->notifications->each(function ($note, $key) use ($uuid) {
				if ($note->id === $uuid) {
					$note->markAsRead();
				}
			});
			
			$notification->read_at = Carbon::parse($notification->read_at)->format('jS M Y H:i');
				
			return view('cp.users.notifications.show', compact('currentUser', 'title', 'subTitle', 'notification'));
		}

		abort(403, 'Unauthorised action');
	}
	
	/**
     * Receives a webhook notification from 3rd party applications/services
     *
	 * @params Request 	$request
     * @return Response
     */
    public function webhook(Request $request) 
    {
	    $cleanedEvent = $this->sanitizerInput($request->all());
	    
		if (!empty($cleanedEvent['event_id'])) {
			switch ($cleanedEvent['event_type']) {
				case 'users.updated':
					$users = $cleanedEvent['data'];
				
					collect($users)->each(function ($data) {
						// Grab and update it
						$user = User::find($data['id']);
					
						if ($user) {
							// Mass assignment
							$user->fill($data);
						
							$user->save();
						
							UserUpdatedEvent::dispatch($user);
						}
					});
					
					break;
			}
		}
	}
}
