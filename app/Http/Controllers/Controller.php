<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Controllers;

use Log;
use Request;
use App\User;
use Carbon\Carbon;
use App\Models\Template;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Validator as ValidatorResponse;
use Illuminate\Support\Facades\{File, Auth, Cache, Validator};
use Illuminate\Support\Collection as SupportCollectionResponse;
use App\Http\Traits\{UserTrait, PageTrait, FieldTrait, ArticleTrait};
use Illuminate\Database\Eloquent\Collection as EloquentCollectionResponse;

class Controller extends BaseController
{
	use UserTrait, PageTrait, FieldTrait, ArticleTrait, DispatchesJobs, AuthorizesRequests, ValidatesRequests;
	
	protected $env;
	
	protected $limit;

	protected $minutes;
	
	protected $datetime;
	
	protected $maxLimit;
	
	protected $cacheKey;
	
	protected $assetsDisk;
	
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
		
		// Cache expiry
		$this->minutes = config('cache.expiry_in_minutes');
		
		$this->cacheKey = '';
		
		$this->maxLimit = 100;
		
		$this->env = env('APP_ENV');
		
		$this->httpStatusCode = 200;
		
		$this->assetsDisk = 'uploads';
		
		$this->cachingEnabled = config('cache.enabled');

		$this->datetime = Carbon::now()->format('Y-m-d H:i:s');
	}
	
	/**
	 * Gets data for the specified model
	 *
	 * @params	string			$model
	 * @param	string			$cacheKey
	 * @return 	Collection
	 */
	protected function getData(string $model, string $cacheKey)
	{
		$data = $this->getCache($cacheKey);
		
		if (is_null($data)) {
			$data = ($this->{$model}());
			
			$this->setCache($cacheKey, $data);
		}
		
		return $data;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @param	string 		$model
	 * @return 	array
	 */
	public function getRules(string $model) : array
	{
		return config('cms.validation_rules.'.$model);
	}

	/**
	 * Creates a new token, used for API and user activations.
	 *
	 * @return	String
	 */
	public function getToken($length = 191) : string
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
	protected function validatorInput(array $data, array $rules) : ValidatorResponse
	{
		return Validator::make($data, $rules);
	}
	
	/**
	 * Sanitise the incoming request.
	 *
	 * @param  	array  $data
	 * @return 	\Illuminate\Contracts\Validation\Validator
	 */
	protected function sanitizerInput(array $data) : array
	{
		$integers = [
			'id',
			'solution_id',
			'article_id',
			'article_category_id',
			'field_id',
			'page_id',
			'content_id',
			'field_type_id',
			'template_id',
			'user_id',
			'required',
			'status_id',
			'default_location_id',
			'delivery_method_id',
			'location_id',
			'county_id',
			'country_id',
			'company_id',
			'parent_id',
			'order_id',
			'product_id',
			'quantity',
			'tax_rate',
			'lft',
			'rgt',
			'depth',
			'role_id',
			'count',
			'permission_id',
			'location_id',
			'size',
			'hide_from_nav',
			'order',
			'event_id',
			'sort_order',
			'import_id',
			'publish_to_web',
			'product_standard_id',
			'product_id',
			'product_standard_organisation_id',
			'product_vat_rate_id',
			'product_category_id',
			'product_manufacturer_id',
			'harmonised_code_id',
			'supplier_id',
			'limited_life',
			'test_certificates_required',
			'retire_employee_id',
		];

		$floats = [
			'price',
			'price_tax',
			'tax',
			'subtotal',
			'total',
		];

		$strings = [
			'short_name',
			'commodity_name_protocol',
			'commodity_code_protocol',
			'commodity_short_description_protocol',
			'image_uri',
			'website',
			'code',
			'logo_image',
			'cms_page_name',
			'timecheck',
			'futher_details',
			'rate',
			'rate_display',
			'event_type',
			'action',
			'identifier',
			'content',
			'instance',
			'row_id',
			'first_name',
			'last_name',
			'jot_title',
			'telephone',
			'mobile',
			'remember_token',
			'title',
			'type',
			'handle',
			'instructions',
			'description',
			'keywords',
			'options',
			'data',
			'slug',
			'unit',
			'building',
			'street_address_1',
			'street_address_2',
			'street_address_3',
			'street_address_4',
			'town_city',
			'postal_code',
			'order_number',
			'po_number',
			'notes',
			'order_type',
			'mime_type',
			'extension',
			'path',
			'filename',
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
	 * Get links for Refactor > Insert Link > Select Link view.
	 *
	 * @params	Request 	$request
	 * @return 	Response
	 */
	public function links(HttpRequest $request)
	{
		$json = [];
		
		$format = $request->get('format');
		
		if (!empty($format) && $format === 'json') {
			array_push($json, [
				'title' => '---- Pages ----',
				'name' => '',
				'url' => '',
			]);
			
			// Add in Pages
			$pages = $this->getPages();
			
			// Only use published pages
			$pages = $pages->filter(function ($page) {
				return $page->isPublished();
			});
			
			// Add indentation to show levels
			foreach ($pages as &$page) {
				$indent = '';
				
				$depth = $page->depth;
				
				while ($depth > 0) {
					$indent .= '-';
					
					$depth--;
				}
				
				if ($indent > '') {
					$indent .= '&nbsp;';
				}
				
				$page->indent = $indent;
			}
			
			// Now add pages to array
			foreach ($pages as $page) {
				array_push($json, [
					'title' => $page->indent.$page->title,
					'name' => $page->title,
					'url' => $page->url,
				]);
			}
			
			array_push($json, []);
			
			array_push($json, [
				'title' => '---- Articles ----',
				'name' => '',
				'url' => '',
			]);
			
			// Add in Articles
			$articles = $this->getArticles();
				
			// Only use published pages
			$articles = $articles->filter(function ($article) {
				return $article->isPublished();
			});

			// Now add pages to array
			foreach ($articles as $article) {
				array_push($json, [
					'title' => $article->indent.$article->title,
					'name' => $article->title,
					'url' => $article->url,
				]);
			}	
		}
		
		return response()->json($json);
	}	
	
	/**
	 * Checks if we are running in console
	 *
	 * @return 	boolean
	 */
	protected function runningInConsole() : bool
	{
		return (php_sapi_name() == 'cli');
	}

	/**
	 * Retrieves the current authenticated guard type.
	 *
	 * @return String
	 */
	protected function getRequestType() : string
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
	protected function getStatusCode() : int
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
	protected function getLimit() : int
	{
		return $this->limit;
	}

	/**
	 * Set limit for an api response.
	 *
	 * @param 	int 		$limit
	 * @return  Response
	 */
	protected function setLimit(int $limit) : int
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
	 * Creates a comma separated string.
	 *
	 * @param  String 	$string
	 * @return String
	 */
	protected function commaSeparate($string) : string
	{
		if (!empty($string)) {
			// Stripe whitespace
			$string = trim($string);
			
			// Split the string first
			$string = explode(' ', $string);
			
			// Join the string again with commas
			$string = implode(',', $string);
			
			// Tidy up commas
			$string = str_replace([' ,', ', ', ',,,', ',,'], ',', $string);
			
			// Tidy up spaces
			$string = str_replace('  ', ' ', $string);
			
			// If last char is a comma, remove it
			if ($string{-1} == ',') {
				$string = substr($string, 0, strlen($string) - 1);
			}
		}
		
		// Stripe whitespace again
		$string = trim($string);
		
		return $string;
	}
	
	/**
	 * Filters company records based on current users company.
	 *
	 * @param  Collection 	$companies
	 * @return Collection
	 */
	protected function filterCompanies($companies) : SupportCollectionResponse
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
	protected function filterUsers($users) : SupportCollectionResponse
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
	protected function filterLocations($locations) : SupportCollectionResponse
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
	protected function filterOrders($orders) : SupportCollectionResponse
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
			
			$users = [];
			
			// Load Admin orders and End User orders
			if ($currentUser->isAdmin()) {
				$users = $currentUser->company->users->filter(function ($user) {
					return !$user->isSuperAdmin();
				});
				
				// Run over all users and grab order ids
				foreach ($users as $user) {
					$allowedOrderIds = array_merge($allowedOrderIds, $user->orders->pluck('id')->toArray());
				}
			} else if ($currentUser->isEndUser()) {
				$allowedOrderIds = $currentUser->orders->pluck('id')->toArray();
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
	 * Filters cart records based on current users company.
	 *
	 * @param  Collection 	$carts
	 * @return Collection
	 */
	protected function filterCarts($carts) : SupportCollectionResponse
	{
		if (count($carts) == 0) {
			return collect($carts);
		}
		
		$currentUser = $this->getAuthenticatedUser();
		
		// If super admin, return everything
		if ($currentUser->isSuperAdmin()) {
			return collect($carts);
		} else {
			$allowedCartIds = [];
			
			$users = [];
			
			// Load Admin orders and End User orders
			if ($currentUser->isAdmin()) {
				$users = $currentUser->company->users->filter(function ($user) {
					return !$user->isSuperAdmin();
				});
				
				// Run over all users and grab cart ids
				foreach ($users as $user) {
					$allowedCartIds = array_merge($allowedCartIds, $user->carts->pluck('identifier')->toArray());
				}
			} else if ($currentUser->isEndUser()) {
				$allowedCartIds = $currentUser->carts->pluck('identifier')->toArray();
			}
			
			$filteredCarts = [];
			
			if (count($allowedCartIds) > 0) {
				foreach ($carts as $cart) {
					if (in_array($cart->identifier, $allowedCartIds)) {
						array_push($filteredCarts, $cart);
					}
				}
			}
			
			return collect($filteredCarts);
		}
	}
	
	/**
	 * Simple gets the cache
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
	 * Simple sets the cache
	 *
	 * @param  String 		$key
	 * @param  Mixed 		$data
	 * @return Collection
	 */
	public function setCache(string $key, $data) 
	{
		if ($this->cachingEnabled) {
			Cache::put($key, $data, $this->minutes);
		}
		
		return $this;
	}
	
	/**
	 * Simple forgets the cache
	 *
	 * @param  String 		$key
	 */
	public function forgetCache(string $key) 
	{
		if ($this->cachingEnabled) {
			Cache::forget($key);
		}
		
		return $this;
	}
	
	/**
	 * Simple flush entire cache
	 */
	public function flushCache() 
	{
		Cache::flush();
		
		return $this;
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
	protected function paginateCollection($collection, $perPage, $pageName = 'page', $fragment = null) : LengthAwarePaginator
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
	
	/**
	 * Does what it says on the tin!
	 */
	protected function mapFieldsToFieldTypes(Template $template) : Template
	{
		$template->reference = 'template_'.$template->filename;
			
		$fields = [];
		
		foreach ($template->fields as $field) {
			if ($field->field_type->id == 1) {
				// Text
				array_push($fields, [
					'template_id' => $template->id,
					'field_type_id' => $field->field_type_id,
					'_id' => $field->id,
					'label' => $field->title,
					'type' => $field->field_type->type,
					'name' => 'templates['.$template->id.']['.$field->id.']',
					'id' => $template->id.'_'.$field->id.'_'.$field->handle,
					'class' => 'form-control',
					'placeholder' => '',
					'value' => '',
					'required' => $field->required == 1 ? true : false,
					'instructions' => $field->instructions,
				]);
			} else if ($field->field_type->id == 2) {
				// Text - Multiline
				array_push($fields, [
					'template_id' => $template->id,
					'field_type_id' => $field->field_type_id,
					'_id' => $field->id,
					'label' => $field->title,
					'type' => $field->field_type->type,
					'name' => 'templates['.$template->id.']['.$field->id.']',
					'id' => $template->id.'_'.$field->id.'_'.$field->handle,
					'class' => 'form-control',
					'placeholder' => '',
					'value' => '',
					'required' => $field->required == 1 ? true : false,
					'instructions' => $field->instructions,
				]);
			} else if ($field->field_type->id == 3) {
				// Text - Rich
				array_push($fields, [
					'template_id' => $template->id,
					'field_type_id' => $field->field_type_id,
					'_id' => $field->id,
					'label' => $field->title,
					'type' => $field->field_type->type,
					'name' => 'templates['.$template->id.']['.$field->id.']',
					'id' => $template->id.'_'.$field->id.'_'.$field->handle,
					'class' => 'form-control redactor',
					'placeholder' => '',
					'value' => '',
					'required' => $field->required == 1 ? true : false,
					'instructions' => $field->instructions,
				]);
			} else if ($field->field_type->id == 4) {
				// Number
				array_push($fields, [
					'template_id' => $template->id,
					'field_type_id' => $field->field_type_id,
					'_id' => $field->id,
					'label' => $field->title,
					'type' => $field->field_type->type,
					'name' => 'templates['.$template->id.']['.$field->id.']',
					'id' => $template->id.'_'.$field->id.'_'.$field->handle,
					'class' => 'form-control',
					'placeholder' => '',
					'value' => '',
					'required' => $field->required == 1 ? true : false,
					'instructions' => $field->instructions,
				]);
			} else if ($field->field_type->id == 5) {
				// Password
				array_push($fields, [
					'template_id' => $template->id,
					'field_type_id' => $field->field_type_id,
					'_id' => $field->id,
					'label' => $field->title,
					'type' => $field->field_type->type,
					'name' => 'templates['.$template->id.']['.$field->id.']',
					'id' => $template->id.'_'.$field->id.'_'.$field->handle,
					'class' => 'form-control',
					'placeholder' => '',
					'value' => '',
					'required' => $field->required == 1 ? true : false,
					'instructions' => $field->instructions,
				]);
			} else if ($field->field_type->id == 6) {
				// Select
				array_push($fields, [
					'template_id' => $template->id,
					'field_type_id' => $field->field_type_id,
					'_id' => $field->id,
					'label' => $field->title,
					'type' => $field->field_type->type,
					'name' => 'templates['.$template->id.']['.$field->id.']',
					'id' => $template->id.'_'.$field->id.'_'.$field->handle,
					'class' => 'form-control',
					'options' => unserialize($field->options),
					'required' => $field->required == 1 ? true : false,
					'default' => [], // array('option4'),
					'instructions' => $field->instructions,
				]);
			} else if ($field->field_type->id == 7) {
				// Select - Multi
				array_push($fields, [
					'template_id' => $template->id,
					'field_type_id' => $field->field_type_id,
					'_id' => $field->id,
					'label' => $field->title,
					'type' => 'multiselect',
					'name' => 'templates['.$template->id.']['.$field->id.']',
					'id' => $template->id.'_'.$field->id.'_'.$field->handle,
					'class' => 'form-control',
					'options' => unserialize($field->options),
					'required' => $field->required == 1 ? true : false,
					'default' => [], // array('option1', 'option4'),
					'instructions' => $field->instructions,
				]);
			} else if ($field->field_type->id == 8) {
				// Radio
				array_push($fields, [
					'template_id' => $template->id,
					'field_type_id' => $field->field_type_id,
					'_id' => $field->id,
					'label' => $field->title,
					'type' => $field->field_type->type,
					'name' => 'templates['.$template->id.']['.$field->id.']',
					'id' => $template->id.'_'.$field->id.'_'.$field->handle,
					'class' => 'form-control',
					'options' => unserialize($field->options),
					'required' => $field->required == 1 ? true : false,
					'default' => [], // array('option3'),
					'instructions' => $field->instructions,
				]);
			} else if ($field->field_type->id == 9) {
				// Checkbox
				array_push($fields, [
					'template_id' => $template->id,
					'field_type_id' => $field->field_type_id,
					'_id' => $field->id,
					'label' => $field->title,
					'type' => $field->field_type->type,
					'name' => 'templates['.$template->id.']['.$field->id.']',
					'id' => $template->id.'_'.$field->id.'_'.$field->handle,
					'class' => 'form-control',
					'options' => unserialize($field->options),
					'required' => $field->required == 1 ? true : false,
					'default' => [], // array('option1', 'option2'),
					'instructions' => $field->instructions,
				]);
			} else if ($field->field_type->id == 10) {
				// File
				array_push($fields, [
					'template_id' => $template->id,
					'field_type_id' => $field->field_type_id,
					'_id' => $field->id,
					'label' => $field->title,
					'type' => $field->field_type->type,
					'name' => 'templates['.$template->id.']['.$field->id.']',
					'id' => $template->id.'_'.$field->id.'_'.$field->handle,
					'class' => 'form-control-file',
					'placeholder' => '',
					'value' => '',
					'required' => $field->required == 1 ? true : false,
					'instructions' => $field->instructions,
				]);
			}
		}
		
		$template->fields = $fields;
		
		return $template;
	}
	
	/**
	 * Does what it says on the tin!
	 */
	protected function mapContentsToFields(Template $template, Collection $contents) : Template
	{
		$template->fields = recursiveObject($template->fields);
		
		foreach ($template->fields as &$field) {
			foreach ($contents as $content) {
				if ($content->field_id == $field->_id) {
					$field->value = $content->data;
				}
				
				/**
				 * We still attempt to match content based on field types incase ids dont match.
				 * We would only enter this logic if the field value is empty and the user was 
				 * creating or editing a page and picked a different template...
				 */
				 
				// Commented out 06/Oct/2017 - Bug investigation - seems to be causing all template fields to be populated with same data
				
				/*
				if (empty($field->value)) {
					$contentField = $this->getField($content->field_id);
					
					if ($contentField->field_type_id == $field->field_type_id) {
						$field->value = $content->data;
					}
				}
				*/
			}
		}
		
		$template->fields = json_decode(json_encode($template->fields), true);
		
		return $template;
	}
	
	/**
	 * Does what it says on the tin!
	 */
	protected function setTemplateFieldRules(array $rules, array $templates) : array
	{
		foreach ($templates as $template_id => $fields) {
			foreach ($fields as $field_id => $field) {
				if (!empty($field)) {
					$field = $this->getField($field_id);
					
					$fieldRules = [];
					
					if ($field->required == 1) {
						array_push($fieldRules, 'required');
					} else {
						array_push($fieldRules, 'nullable');
					}
					
					if ($field->field_type->type == 'text') {
						array_push($fieldRules, 'string');
						array_push($fieldRules, 'max:255');
					}
					
					if ($field->field_type->type == 'textarea') {
						array_push($fieldRules, 'string');
					}
					
					if ($field->field_type->type == 'number') {
						array_push($fieldRules, 'integer');
					}
					
					if ($field->field_type->type == 'password') {
						array_push($fieldRules, 'string');
						array_push($fieldRules, 'max:255');
					}
					
					if ($field->field_type->type == 'select') {
						array_push($fieldRules, 'integer');
					}
					
					if ($field->field_type->type == 'radio') {
						array_push($fieldRules, 'integer');
					}
					
					if ($field->field_type->type == 'checkbox' && $field->required) {
						array_push($fieldRules, 'array');
						array_push($fieldRules, 'min:1');
					}
					
					if ($field->field_type->type == 'file' && $field->required) {
						array_push($fieldRules, 'file');
						array_push($fieldRules, 'max:3000');
					}
					
					if (count($fieldRules) > 0) {
						$rules['templates.'.$template_id.'.'.$field_id] = implode('|', $fieldRules);
					}
				}
			}
		}
		
		return $rules;
	}
}
