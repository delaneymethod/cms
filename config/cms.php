<?php

return [
	
	/*
    |--------------------------------------------------------------------------
    | Client Configuration
    |--------------------------------------------------------------------------
    */
    
    'version' => '1.0.0',
    
    'client' => [
	    
		'name' => env('CLIENT_NAME', 'DelaneyMethod'),
		'url' => env('CLIENT_URL', 'http://www.delaneymethod.com'),
		'email' => env('MAIL_FROM_ADDRESS', 'hello@delaneymethod.com'),
    
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
		
		'cart' => [
			'instance' => 'required|string|in:cart,wishlist',
		],
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
			'template_id' => 'required|integer',
			'status_id' => 'required|integer',
			'parent_id' => 'required|integer',
		],
		'company' => [
			'title' => 'required|string|max:255',
			'default_location_id' => 'required|integer',
		],
		'order' => [
			'order_number' => 'required|string|max:255',
			'po_number' => 'required|string|max:255',
			'notes' => 'nullable|string',
			'order_type_id' => 'required|integer',
			'shipping_method_id' => 'required|integer',
			'location_id' => 'required|integer',
			'user_id' => 'required|integer',
			'status_id' => 'required|integer',
			'count' => 'required|integer',
			'tax' => 'required|numeric',
			'subtotal' => 'required|numeric',
			'total' => 'required|numeric',
		],
		'article' => [
			'title' => 'required|string|max:255',
			'slug' => 'required|string|unique:articles,slug|max:255',
			'description' => 'nullable|string',
			'keywords' => 'nullable|string',
			'template_id' => 'required|integer',
			'user_id' => 'required|integer',
			'status_id' => 'required|integer',
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
		'product' => [
			'title' => 'required|string|max:255',
			'slug' => 'required|string|unique:products,slug|max:255',
			'price' => 'required|numeric',
		],
		'role' => [
			'title' => 'required|string|max:255',
		],
		'template' => [
			'title' => 'required|string|max:255',
			'filename' => 'required|string|unique:templates,filename|max:255',
		],
		'status' => [
			'title' => 'required|string|max:255',
			'description' => 'string|max:255',
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
	
	/*
    |--------------------------------------------------------------------------
    | Grid Configuration
    |--------------------------------------------------------------------------
    */
	
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
	
	/*
	|--------------------------------------------------------------------------
	| Error Configuration
	|--------------------------------------------------------------------------
	|
	| Used for exception error handling and other API related controllers.
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
	
	'directory_helper' => [
		'home_label' => 'Assets',
		'hide_dot_files' => true,
		'list_folders_first' => true,
		'list_sort_order' => 'natcasesort',
		'date_format' => 'Y-m-d H:i:s',
	
		'hidden_files' => [
			'resources',
			'resources/*',
			'assets',
			'assets/*',
			'*/conversions',
			'.ht*',
			'*/.ht*',
			'.htaccess',
			'favicon.ico',
			'mix-manifest.json',
			'mix.*',
			'mix.js',
			'robots.txt',
			'web.config',
		],
	
		// If set to 'true' an directory with an index file (as defined below) will
		// become a direct link to the index page instead of a browsable directory
		'links_dirs_with_index' => false,
	
		// Make linked directories open in a new (_blank) tab
		'external_links_new_window' => true,
	
		// Files that, if present in a directory, make the directory
		// a direct link rather than a browse link.
		'index_files' => [
			'index.php',
		],
	
		// File hashing threshold
		'hash_size_limit' => 268435456, // 256 MB
		
		// Custom sort order
		'reverse_sort' => [
			// 'path/to/folder'
		],
	
		// Allow to download directories as zip files
		'zip_dirs' => true,
	
		// Stream zip file content directly to the client,
		// without any temporary file
		'zip_stream' => true,
	
		'zip_compression_level' => 0,
	
		// Disable zip downloads for particular directories
		'zip_disable' => [
			// 'path/to/folder'
		],
		
		'file_types' => [
			// Archives
			'7z' => 'fa-file-archive-o',
			'bz' => 'fa-file-archive-o',
			'gz' => 'fa-file-archive-o',
			'rar' => 'fa-file-archive-o',
			'tar' => 'fa-file-archive-o',
			'zip' => 'fa-file-archive-o',
			
			// Audio
			'aac' => 'fa-music',
			'flac' => 'fa-music',
			'mid' => 'fa-music',
			'midi' => 'fa-music',
			'mp3' => 'fa-music',
			'ogg' => 'fa-music',
			'wma' => 'fa-music',
			'wav' => 'fa-music',
			
			// Code
			'c' => 'fa-code',
			'class' => 'fa-code',
			'cpp' => 'fa-code',
			'css' => 'fa-code',
			'erb' => 'fa-code',
			'htm' => 'fa-code',
			'html' => 'fa-code',
			'java' => 'fa-code',
			'js' => 'fa-code',
			'php' => 'fa-code',
			'pl' => 'fa-code',
			'py' => 'fa-code',
			'rb' => 'fa-code',
			'xhtml' => 'fa-code',
			'xml' => 'fa-code',
			
			// Databases
			'accdb' => 'fa-hdd-o',
			'db' => 'fa-hdd-o',
			'dbf' => 'fa-hdd-o',
			'mdb' => 'fa-hdd-o',
			'pdb' => 'fa-hdd-o',
			'sql' => 'fa-hdd-o',
			
			// Documents
			'csv' => 'fa-file-text',
			'doc' => 'fa-file-text',
			'docx' => 'fa-file-text',
			'odt' => 'fa-file-text',
			'pdf' => 'fa-file-text',
			'xls' => 'fa-file-text',
			'xlsx' => 'fa-file-text',
			
			// Executables
			'app' => 'fa-list-alt',
			'bat' => 'fa-list-alt',
			'com' => 'fa-list-alt',
			'exe' => 'fa-list-alt',
			'jar' => 'fa-list-alt',
			'msi' => 'fa-list-alt',
			'vb' => 'fa-list-alt',
			
			// Fonts
			'eot' => 'fa-font',
			'otf' => 'fa-font',
			'ttf' => 'fa-font',
			'woff' => 'fa-font',
			
			// Game Files
			'gam' => 'fa-gamepad',
			'nes' => 'fa-gamepad',
			'rom' => 'fa-gamepad',
			'sav' => 'fa-floppy-o',
			
			// Images
			'bmp' => 'fa-picture-o',
			'gif' => 'fa-picture-o',
			'jpg' => 'fa-picture-o',
			'jpeg' => 'fa-picture-o',
			'png' => 'fa-picture-o',
			'psd' => 'fa-picture-o',
			'tga' => 'fa-picture-o',
			'tif' => 'fa-picture-o',
			
			// Package Files
			'box' => 'fa-archive',
			'deb' => 'fa-archive',
			'rpm' => 'fa-archive',
			
			// Scripts
			'bat' => 'fa-terminal',
			'cmd' => 'fa-terminal',
			'sh' => 'fa-terminal',
			
			// Text
			'cfg' => 'fa-file-text',
			'ini' => 'fa-file-text',
			'log' => 'fa-file-text',
			'md' => 'fa-file-text',
			'rtf' => 'fa-file-text',
			'txt' => 'fa-file-text',
			
			// Vector Images
			'ai' => 'fa-picture-o',
			'drw' => 'fa-picture-o',
			'eps' => 'fa-picture-o',
			'ps' => 'fa-picture-o',
			'svg' => 'fa-picture-o',
			
			// Video
			'avi' => 'fa-youtube-play',
			'flv' => 'fa-youtube-play',
			'mkv' => 'fa-youtube-play',
			'mov' => 'fa-youtube-play',
			'mp4' => 'fa-youtube-play',
			'mpg' => 'fa-youtube-play',
			'ogv' => 'fa-youtube-play',
			'webm' => 'fa-youtube-play',
			'wmv' => 'fa-youtube-play',
			'swf' => 'fa-youtube-play',
			
			// Other
			'bak' => 'fa-floppy',
			'msg' => 'fa-envelope',
			
			// Blank
			'blank' => 'fa-file',
		],
	],
	
];
