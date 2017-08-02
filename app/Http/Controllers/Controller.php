<?php

namespace App\Http\Controllers;

use Request;
use Carbon\Carbon;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
	use UserTrait;
	use DispatchesJobs;
	use AuthorizesRequests;
	use ValidatesRequests;
	
	protected $env;
	
	protected $limit;

	protected $minutes;
	
	protected $datetime;
	
	protected $maxLimit;
	
	protected $cachingEnabled;

	protected $httpStatusCode;
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->limit = 100;
		
		$this->minutes = 60;
		
		$this->maxLimit = 100;
		
		$this->env = env('APP_ENV');
		
		$this->httpStatusCode = 200;
		
		$this->cachingEnabled = config('cache.enabled');

		$this->datetime = Carbon::now()->format('Y-m-d H:i:s');
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @param	string 		$model
	 * @return 	array
	 */
	public function getRules(string $model)
	{
		return config('grampianfasteners.validation_rules.'.$model);
	}

	/**
	 * Creates a new token, used for API and user activations.
	 *
	 * @return	String
	 */
	public function getToken($length = 191)
	{
		return hash_hmac('sha256', str_random($length), config('app.key'));
	}
	
	/**
	 * Validate the incoming request.
	 *
	 * @param  	array  	$data
	 * @param	array	$data
	 * @return 	\Illuminate\Contracts\Validation\Validator
	 */
	protected function validatorInput(array $data, array $rules)
	{
		return Validator::make($data, $rules);
	}
	
	/**
	 * Sanitise the incoming request.
	 *
	 * @param  	array  $data
	 * @return 	\Illuminate\Contracts\Validation\Validator
	 */
	protected function sanitizerInput(array $data)
	{
		$integers = [
			'id',
			'article_id',
			'category_id',
			'user_id',
			'status_id',
			'default_location_id',
			'county_id',
			'country_id',
			'company_id',
			'parent_id',
			'lft',
			'rgt',
			'depth',
			'role_id',
			'permission_id',
			'location_id',
			'size',
		];

		$floats = [
		];

		$strings = [
			'first_name',
			'last_name',
			'jot_title',
			'telephone',
			'mobile',
			'remember_token',
			'title',
			'slug',
			'content',
			'unit',
			'building',
			'street_address_1',
			'street_address_2',
			'street_address_3',
			'street_address_4',
			'town_city',
			'postal_code',
			'hash_name',
			'original_name',
			'mime_type',
			'extension',
			'path',
		];

		$booleans = [
		];

		$emails = [
			'email',
		];

		$urls = [
		];

		$passwords = [
			'password',
			'password_confirm',
		];

		foreach ($data as $key => &$value) {
			if (is_array($value)) {
				$this->sanitizerInput($value);
			} else {
				if (in_array($key, $integers)) {
					$value = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
				} elseif (in_array($key, $strings)) {
					$value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_SANITIZE_MAGIC_QUOTES);
				} elseif (in_array($key, $floats)) {
					$value = filter_var($value, FILTER_VALIDATE_FLOAT);
				} elseif (in_array($key, $booleans)) {
					$value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
				} elseif (in_array($key, $emails)) {
					$value = filter_var($value, FILTER_VALIDATE_EMAIL);
				} elseif (in_array($key, $urls)) {
					$value = filter_var($value, FILTER_VALIDATE_URL);
				} elseif (in_array($key, $passwords)) {
					$value = strip_tags($value);
				}
			}
		}

		return $data;
	}
	
	/**
	 * Checks if we are running in console
	 *
	 * @return 	boolean
	 */
	protected function runningInConsole()
	{
		return (php_sapi_name() == 'cli');
	}

	/**
	 * Retrieves the current authenticated guard type.
	 *
	 * @return String
	 */
	protected function getRequestType()
	{
		return Auth::guard('api')->check() ? 'api' : 'web';
	}

	/**
	 * Retrieves the current authenticated user's id.
	 *
	 * @return Object
	 */
	protected function getAuthenticatedUserId()
	{
		return Auth::id();
	}

	/**
	 * Retrieves the current authenticated user.
	 *
	 * @return Object
	 */
	protected function getAuthenticatedUser()
	{
		return Auth::user();
	}

	/**
	 * Checks if account is authenticated.
	 *
	 * @return 	Response
	 */
	protected function checkAuthentication()
	{
		if (is_null(Auth::guard('api')->user())) {
			// The request is using an invalid api token or none at all, so stop the request dead in its tracks - needs to be authenicated first!
			return new AuthenticationException();
		}

		return true;
	}

	/**
	 * Get status code for an api response.
	 *
	 * @return 	Response
	 */
	protected function getStatusCode()
	{
		return $this->httpStatusCode;
	}

	/**
	 * Set status code for an api response.
	 *
	 * @param 	int 		$httpStatusCode
	 * @return  Response
	 */
	protected function setStatusCode(int $httpStatusCode)
	{
		$this->httpStatusCode = $httpStatusCode;

		// Added so we can chain calls
		return $this;
	}

	/**
	 * Get limit for an api response.
	 *
	 * @return 	Response
	 */
	protected function getLimit()
	{
		return $this->limit;
	}

	/**
	 * Set limit for an api response.
	 *
	 * @param 	int 		$limit
	 * @return  Response
	 */
	protected function setLimit(int $limit)
	{
		$this->limit = ($limit === 0 || $limit > $this->maxLimit) ? $this->maxLimit : $limit;
	}

	/**
	 * Check if the limit is valid for an api response.
	 *
	 * @param 	mixed 		$limit
	 * @return  Response
	 */
	protected function isValidLimit($limit)
	{
		return (!is_int($limit) ? (ctype_digit($limit)) : true);
	}

	/**
	 * Carries out a few checks on the limit param and if valid, sets the limit for pagination.
	 *
	 * @param	$limit
	 */
	protected function validateLimit($limit)
	{
		$requestType = $this->getRequestType();

		$isValid = $this->isValidLimit($limit);

		if (!$isValid) {
			if ($requestType === 'api') {
				// If API request, we want to throw the invalid limit in the JSON response
				return $this->setStatusCode(400)->respondWithInvalidLimit();
			} else {
				// If other request, e.g via cp, we want to throw the invalid limit as an onscreen error message.
				abort(500, 'Invalid limit');
			}
		}

		$this->setLimit($limit);
	}
	
	/**
	 * Filters company records based on current users company.
	 *
	 * @param  Collection 	$companies
	 * @return Collection
	 */
	protected function filterCompanies($companies)
	{
		if (count($companies) == 0) {
			return collect($companies);
		}
		
		$currentUser = $this->getAuthenticatedUser();
	
		// If super admin, return everything
		if ($currentUser->isSuperAdmin()) {
			return collect($companies);
		} else {
			$filteredCompanies = [];
			
			foreach ($companies as $company) {
				if ($company->id == $currentUser->company_id) {
					array_push($filteredCompanies, $company);
				}
			}
			
			return collect($filteredCompanies);
		}
	}
	
	/**
	 * Filters user records based on current users company.
	 *
	 * @param  Collection 	$users
	 * @return Collection
	 */
	protected function filterUsers($users)
	{
		if (count($users) == 0) {
			return collect($users);
		}
		
		$currentUser = $this->getAuthenticatedUser();
	
		// If super admin, return everything
		if ($currentUser->isSuperAdmin()) {
			return collect($users);
		} else {
			$filteredUsers = [];
			
			foreach ($users as $user) {
				if ($user->company_id == $currentUser->company_id) {
					array_push($filteredUsers, $user);
				}
			}
			
			return collect($filteredUsers);
		}
	}
	
	/**
	 * Filters location records based on current users company.
	 *
	 * @param  Collection 	$locations
	 * @return Collection
	 */
	protected function filterLocations($locations)
	{
		if (count($locations) == 0) {		
			return collect($locations);
		}
		
		$currentUser = $this->getAuthenticatedUser();
	
		// If super admin, return everything
		if ($currentUser->isSuperAdmin()) {
			return collect($locations);
		} else {
			$allowedLocationIds = $currentUser->company->locations->pluck('id')->toArray();
			
			$filteredLocations = [];
			
			if (count($allowedLocationIds) > 0) {
				foreach ($locations as $location) {
					if (in_array($location->id, $allowedLocationIds)) {
						array_push($filteredLocations, $location);
					}
				}
			}
			
			return collect($filteredLocations);
		}
	}
	
	/**
	 * Filters order records based on current users company.
	 *
	 * @param  Collection 	$orders
	 * @return Collection
	 */
	protected function filterOrders($orders)
	{
		if (count($orders) == 0) {		
			return collect($orders);
		}
		
		$currentUser = $this->getAuthenticatedUser();
		
		// If super admin, return everything
		if ($currentUser->isSuperAdmin()) {
			return collect($orders);
		} else {
			$allowedOrderIds = [];
			
			// Run over all users in current users company and grab order ids
			foreach ($currentUser->company->users as $user) {
				$allowedOrderIds = array_merge($allowedOrderIds, $user->orders->pluck('id')->toArray());
			}
			
			$filteredOrders = [];
			
			if (count($allowedOrderIds) > 0) {
				foreach ($orders as $order) {
					if (in_array($order->id, $allowedOrderIds)) {
						array_push($filteredOrders, $order);
					}
				}
			}
			
			return collect($filteredOrders);
		}
	}
	
	/**
	 * Simple get cache
	 *
	 * @param  String 		$key
	 * @return Collection
	 */
	public function getCache(string $key) 
	{
		if ($this->cachingEnabled) {
			return Cache::get($key);
		}
		
		return null;
	}
	
	/**
	 * Simple set cache
	 *
	 * @param  String 		$key
	 * @param  Mixed 		$data
	 * @param  int 			$expiry
	 * @return Collection
	 */
	public function setCache(string $key, $data) 
	{
		if ($this->cachingEnabled) {
			return Cache::put($key, $data, 60);
		}
	}
	
	/**
	 * Simple flush cache
	 *
	 * @param  String 		$key
	 */
	public function flushCache(string $key) 
	{
		if ($this->cachingEnabled) {
			return Cache::forget($key);
		}
	}
	
	/**
	 * Instantiates our very own LengthAwarePaginator used on custom collections
	 *
	 * @param  Collection 	$collection
	 * @param  int 			$perPage
	 * @param  string 		$pageName
	 * @param  mixed 		$fragment
	 * @return Collection
	 */
	protected function paginateCollection($collection, $perPage, $pageName = 'page', $fragment = null)
	{
		$currentPage = LengthAwarePaginator::resolveCurrentPage($pageName);

		$currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage);

		$accessToken = Request::header('Authorization');

		parse_str(request()->getQueryString(), $query);

		unset($query[$pageName]);

		if (!is_null($accessToken) && str_contains($accessToken, 'Bearer')) {
			$query['api_token'] = trim(str_replace('Bearer', '', $accessToken));
		}

		$paginator = new LengthAwarePaginator($currentPageItems, $collection->count(), $perPage, $currentPage, [
			'pageName' => $pageName,
			'path' => LengthAwarePaginator::resolveCurrentPath(),
			'query' => $query,
			'fragment' => $fragment
		]);

		return $paginator;
	}
}
