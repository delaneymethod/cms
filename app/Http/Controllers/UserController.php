<?php

namespace App\Http\Controllers;

use DB;
use Log;
use App\User;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	use UserTrait;
	
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
		$page = [];
		
		$page['title'] = 'Users';
		$page['subTitle'] = '';
		
		$users = $this->getUsers();
		
		return view('cp.users.index', compact('page', 'users'));
	}
	
	/**
	 * Shows a form for creating a new user.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
   	public function create(Request $request)
	{
	}
	
	/**
     * Creates a new user.
     *
	 * @params	Request 	$request
     * @return Response
     */
    public function store(Request $request)
    {
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
