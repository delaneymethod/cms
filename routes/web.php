<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// FRONT END ROUTES

// Cart routes
Route::get('/cart/save', 'CartController@save');
Route::get('/cart/restore/{identifier}', 'CartController@restore');
Route::post('/cart', 'CartController@store');
Route::put('/cart/{rowId}', 'CartController@update');
Route::patch('/cart/{rowId}', 'CartController@update');
Route::delete('/cart', 'CartController@delete');

// Articles routes
Route::get('/articles/{slug}', 'ArticleController@show');

// Products routes
Route::get('/products/{slug}', 'ProductController@show');

// Order routes
Route::post('/orders', 'OrderController@store');

// BACK END ROUTES
Route::group(['prefix' => 'cp'], function () {
	// CP route
	Route::get('/', function () {
		return redirect('/cp/dashboard');
	});

	// CP > Dashboard routes
	Route::get('/dashboard', 'DashboardController@index');

	// CP > Users routes
	Route::get('/users', 'UserController@index');
	Route::get('/users/create', 'UserController@create');
	Route::get('/users/{id}/edit', 'UserController@edit');
	Route::get('/users/{id}/edit/password', 'UserController@editPassword');
	Route::get('/users/{id}/retire', 'UserController@retire');
	Route::get('/users/{id}/delete', 'UserController@confirm');
	Route::post('/users', 'UserController@store');
	Route::put('/users/{id}', 'UserController@update');
	Route::patch('/users/{id}', 'UserController@update');
	Route::delete('/users/{id}', 'UserController@delete');
	
	// CP > Companies routes
	Route::get('/companies', 'CompanyController@index');
	Route::get('/companies/create', 'CompanyController@create');
	Route::get('/companies/{id}/edit', 'CompanyController@edit');
	Route::get('/companies/{id}/delete', 'CompanyController@confirm');
	Route::post('/companies', 'CompanyController@store');
	Route::put('/companies/{id}', 'CompanyController@update');
	Route::patch('/companies/{id}', 'CompanyController@update');
	Route::delete('/companies/{id}', 'CompanyController@delete');
	
	// CP > Locations routes
	Route::get('/locations', 'LocationController@index');
	Route::get('/locations/create', 'LocationController@create');
	Route::get('/locations/{id}/edit', 'LocationController@edit');
	Route::get('/locations/{id}/retire', 'LocationController@retire');
	Route::get('/locations/{id}/delete', 'LocationController@confirm');
	Route::post('/locations', 'LocationController@store');
	Route::put('/locations/{id}', 'LocationController@update');
	Route::patch('/locations/{id}', 'LocationController@update');
	Route::delete('/locations/{id}', 'LocationController@delete');
	
	// CP > Orders routes
	Route::get('/orders', 'OrderController@index');
	Route::get('/orders/{id}/edit', 'OrderController@edit');
	Route::get('/orders/{id}/delete', 'OrderController@confirm');
	Route::put('/orders/{id}', 'OrderController@update');
	Route::patch('/orders/{id}', 'OrderController@update');
	Route::delete('/orders/{id}', 'OrderController@delete');
	
	// CP > Articles routes
	Route::get('/articles', 'ArticleController@index');
	Route::get('/articles/create', 'ArticleController@create');
	Route::get('/articles/{id}/edit', 'ArticleController@edit');
	Route::get('/articles/{id}/delete', 'ArticleController@confirm');
	Route::post('/articles', 'ArticleController@store');
	Route::put('/articles/{id}', 'ArticleController@update');
	Route::patch('/articles/{id}', 'ArticleController@update');
	Route::delete('/articles/{id}', 'ArticleController@delete');
	
	// CP > Categories routes
	Route::get('/categories', 'CategoryController@index');
	Route::get('/categories/create', 'CategoryController@create');
	Route::get('/categories/{id}/edit', 'CategoryController@edit');
	Route::get('/categories/{id}/delete', 'CategoryController@confirm');
	Route::post('/categories', 'CategoryController@store');
	Route::put('/categories/{id}', 'CategoryController@update');
	Route::patch('/categories/{id}', 'CategoryController@update');
	Route::delete('/categories/{id}', 'CategoryController@delete');
	
	// CP > Products routes
	Route::get('/products', 'ProductController@index');
	Route::get('/products/create', 'ProductController@create');
	Route::get('/products/{id}/edit', 'ProductController@edit');
	Route::get('/products/{id}/delete', 'ProductController@confirm');
	Route::post('/products', 'ProductController@store');
	Route::put('/products/{id}', 'ProductController@update');
	Route::patch('/products/{id}', 'ProductController@update');
	Route::delete('/products/{id}', 'ProductController@delete');
	
	// CP > Carts routes
	Route::get('/carts', 'CartController@index');
	
	// CP > Templates routes
	Route::get('/templates', 'TemplateController@index');
	
	// CP > Pages routes
	Route::get('/pages', 'PageController@index');
	Route::get('/pages/create', 'PageController@create');
	Route::get('/pages/create/{template_id}', 'PageController@create');
	Route::get('/pages/{id}/edit', 'PageController@edit');
	Route::get('/pages/{id}/edit/{template_id}', 'PageController@edit');
	Route::get('/pages/{id}/delete', 'PageController@confirm');
	Route::post('/pages', 'PageController@store');
	Route::post('/pages/reload', 'PageController@reload');
	Route::put('/pages/{id}', 'PageController@update');
	Route::patch('/pages/{id}', 'PageController@update');
	Route::delete('/pages/{id}', 'PageController@delete');
	
	// CP > Menu routes
	Route::get('/menu', 'PageController@menu');
	Route::put('/menu', 'PageController@tree');
	Route::patch('/menu', 'PageController@tree');
	
	// CP > Advanced routes
	Route::get('/advanced', 'RoleController@index');
	
	// CP > Roles routes
	Route::get('/advanced/roles', 'RoleController@index');
	Route::get('/advanced/roles/create', 'RoleController@create');
	Route::get('/advanced/roles/{id}/edit', 'RoleController@edit');
	Route::get('/advanced/roles/{id}/delete', 'RoleController@confirm');
	Route::post('/advanced/roles', 'RoleController@store');
	Route::post('/advanced/roles/permissions', 'RoleController@permissions');
	Route::put('/advanced/roles/{id}', 'RoleController@update');
	Route::patch('/advanced/roles/{id}', 'RoleController@update');
	Route::delete('/advanced/roles/{id}', 'RoleController@delete');
	
	// CP > Permissions routes
	Route::get('/advanced/permissions', 'PermissionController@index');
	
	// CP > Statuses routes
	Route::get('/advanced/statuses', 'StatusController@index');
	Route::get('/advanced/statuses/create', 'StatusController@create');
	Route::get('/advanced/statuses/{id}/edit', 'StatusController@edit');
	Route::get('/advanced/statuses/{id}/delete', 'StatusController@confirm');
	Route::post('/advanced/statuses', 'StatusController@store');
	Route::put('/advanced/statuses/{id}', 'StatusController@update');
	Route::patch('/advanced/statuses/{id}', 'StatusController@update');
	Route::delete('/advanced/statuses/{id}', 'StatusController@delete');
	
	// CP > Assets routes
	Route::get('/assets', 'AssetController@index');
	Route::get('/assets/upload', 'AssetController@upload');
	Route::post('/assets', 'AssetController@store');
});

// CATCH ALL ROUTE
Route::get('{catchAll}', 'PageController@page')->where('catchAll', '(.*)');
