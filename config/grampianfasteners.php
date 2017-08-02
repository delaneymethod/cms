<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Error Configuration
	|--------------------------------------------------------------------------
	|
	| Added by Sean - Used for exception error handling and other API related controllers.
	|
	*/

	'api_error_messages' => [

		'400' => [
			'error' => [
				'type' => 'bad_request',
				'message' => 'A 400 status code indicates that the server did not understand the request, possibility due to bad syntax.',
				'code' => 10,
			],
		],
		'401' => [
			'error' => [
				'type' => 'unauthorised',
				'message' => 'A 401 status code indicates that before a resource can be accessed, the client must be authorised by the server.',
				'code' => 20,
			],
		],
		'403' => [
			'error' => [
				'type' => 'forbidden',
				'message' => 'A 403 status code indicates that the client cannot access the requested resource. That might mean that the wrong username and password were sent in the request, or that the permissions on the server do not allow what was being asked.',
				'code' => 30,
			],
		],
		'404' => [
			'error' => [
				'type' => 'not_found',
				'message' => 'A 404 status code indicates that the requested resource was not found at the URL given, and the server has no idea how long for.',
				'code' => 40,
			],
		],
		'405' => [
			'error' => [
				'type' => 'method_not_allowed',
				'message' => 'A 405 status code indicates that the client has tried to use a request method that the server does not allow.',
				'code' => 50,
			],
		],
		'410' => [
			'error' => [
				'type' => 'gone',
				'message' => 'A 410 status code indicates that the resource has permanently gone, and no new address is known for it.',
				'code' => 60,
			],
		],
		'500' => [
			'error' => [
				'type' => 'internal_server_error',
				'message' => 'A 500 status code indicates that the server encountered something it didn\'t expect and was unable to complete the request.',
				'code' => 70,
			],
		],
	
	],

	/*
	|--------------------------------------------------------------------------
	| Model Validation Rules Configuration
	|--------------------------------------------------------------------------
	|
	| Added by Sean - Used for API related controllers when validating POST, PUT and PATCH request.
	|
	*/

	'validation_rules' => [
		
		'category' => [
			'title' => 'required|string|max:255',
			'slug' => 'required|string|unique:categories,slug|max:255',
			'status_id' => 'required|integer',
		],
		'page' => [
			'title' => 'required|string|max:255',
			'slug' => 'required|string|unique:pages,slug|max:255',
			'description' => 'nullable|string',
			'keywords' => 'nullable|string',
			'status_id' => 'required|integer',
			'content' => 'nullable|string',
			'parent_id' => 'required|integer',
		],
		'company' => [
			'title' => 'required|string|max:255',
			'default_location_id' => 'required|integer',
		],
		'order' => [
			'title' => 'required|string|max:255',
			'user_id' => 'required|integer',
			'status_id' => 'required|integer',
		],
		'article' => [
			'title' => 'required|string|max:255',
			'slug' => 'required|string|unique:articles,slug|max:255',
			'description' => 'nullable|string',
			'keywords' => 'nullable|string',
			'user_id' => 'required|integer',
			'status_id' => 'required|integer',
			'content' => 'nullable|string',
			'published_at' => 'required|date',
		],
		'location' => [
			'title' => 'required|string|max:255',
			'unit' => 'nullable|string|max:255',
			'building' => 'nullable|string|max:255',
			'street_address_1' => 'required|string|max:255',
			'street_address_2' => 'nullable|string|max:255',
			'street_address_3' => 'nullable|string|max:255',
			'street_address_4' => 'nullable|string|max:255',
			'town_city' => 'required|string|max:255',
			'postal_code' => 'nullable|string|max:255',
			'county_id' => 'required|integer',
			'country_id' => 'required|integer',
			'telephone' => 'required|phone:AUTO|string',
			'company_id' => 'required|integer',
			'status_id' => 'required|integer',
		],
		'role' => [
			'title' => 'required|string|max:255',
		],
		'status' => [
			'title' => 'required|string|max:255',
		],
		'permission' => [
			'title' => 'required|string|max:255',
		],
		'country' => [
			'title' => 'required|string|max:255',
		],
		'county' => [
			'title' => 'required|string|max:255',
			'country_id' => 'required|integer',
		],
		'user' => [
			'first_name' => 'required|string|max:255',
			'last_name' => 'required|string|max:255',
			'email' => 'required|email|unique:users,email|max:255',
			'password' => 'required|string|max:255',
			'job_title' => 'required|string|max:255',
			'telephone' => 'required|phone:AUTO|string',
			'mobile' => 'nullable|phone:AUTO|string',
			'company_id' => 'required|integer',
			'location_id' => 'required|integer',
			'status_id' => 'required|integer',
			'role_id' => 'required|integer',
		],
	
	],
	
	'column_widths' => [
		
		'cp' => [
			'sidebar' => [
				'sm' => 'col-sm-12',
				'md' => 'col-md-2',
				'lg' => 'col-lg-2',
			],
			
			'main' => [
				'sm' => 'col-sm-12',
				'md' => 'col-md-10',
				'lg' => 'col-lg-10',
			],
		],
		
	],

];
