<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

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

// Order routes
Route::get('/orders/{id}/pdf', 'OrderController@pdf');
Route::post('/orders', 'OrderController@store');

// Products routes
Route::get('/products/{catchAll}', 'ProductController@show')->where('catchAll', '(.*)');

// BACK END ROUTES
Route::group(['prefix' => 'cp'], function () {
	// CP route
	Route::redirect('/', '/cp/dashboard', 301);
	
	// CP > Dashboard routes
	Route::get('/dashboard', 'DashboardController@index');

	// CP > Users routes
	Route::get('/users', 'UserController@index');
	Route::get('/users/create', 'UserController@create');
	Route::get('/users/{id}/notifications', 'UserController@notifications');
	Route::get('/users/{id}/notifications/{uuid}', 'UserController@notification');
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
	Route::get('/locations/{id}/suspend', 'LocationController@suspend');
	Route::get('/locations/{id}/delete', 'LocationController@confirm');
	Route::post('/locations', 'LocationController@store');
	Route::put('/locations/{id}', 'LocationController@update');
	Route::patch('/locations/{id}', 'LocationController@update');
	Route::delete('/locations/{id}', 'LocationController@delete');
	
	// CP > Orders routes
	Route::get('/orders', 'OrderController@index');
	Route::get('/orders/{id}', 'OrderController@show');
	Route::get('/orders/{id}/pdf', 'OrderController@pdf');
	
	Route::group(['prefix' => 'articles'], function () {
		// CP > Articles routes
		Route::redirect('/', '/cp/articles/all', 301);
		
		Route::get('/all', 'ArticleController@index');
		Route::get('/create', 'ArticleController@create');
		Route::get('/{id}/edit', 'ArticleController@edit');
		Route::get('/{id}/delete', 'ArticleController@confirm');
		Route::post('/', 'ArticleController@store');
		Route::put('/{id}', 'ArticleController@update');
		Route::patch('/{id}', 'ArticleController@update');
		Route::delete('/{id}', 'ArticleController@delete');
		
		// CP > Categories routes
		Route::get('/categories', 'ArticleCategoryController@index');
		Route::get('/categories/create', 'ArticleCategoryController@create');
		Route::get('/categories/{id}/edit', 'ArticleCategoryController@edit');
		Route::get('/categories/{id}/delete', 'ArticleCategoryController@confirm');
		Route::post('/categories', 'ArticleCategoryController@store');
		Route::put('/categories/{id}', 'ArticleCategoryController@update');
		Route::patch('/categories/{id}', 'ArticleCategoryController@update');
		Route::delete('/categories/{id}', 'ArticleCategoryController@delete');
	});
	
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
	Route::get('/carts/{identifier}', 'CartController@show');
	
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
	
	Route::group(['prefix' => 'advanced'], function () {
		// CP > Advanced routes
		Route::redirect('/', '/cp/advanced/roles', 301);
		
		// CP > Roles routes
		Route::get('/roles', 'RoleController@index');
		Route::get('/roles/create', 'RoleController@create');
		Route::get('/roles/{id}/edit', 'RoleController@edit');
		Route::get('/roles/{id}/delete', 'RoleController@confirm');
		Route::post('/roles', 'RoleController@store');
		Route::post('/roles/permissions', 'RoleController@permissions');
		Route::put('/roles/{id}', 'RoleController@update');
		Route::patch('/roles/{id}', 'RoleController@update');
		Route::delete('/roles/{id}', 'RoleController@delete');
		
		// CP > Permissions routes
		Route::get('/permissions', 'PermissionController@index');
		
		// CP > Statuses routes
		Route::get('/statuses', 'StatusController@index');
		Route::get('/statuses/create', 'StatusController@create');
		Route::get('/statuses/{id}/edit', 'StatusController@edit');
		Route::get('/statuses/{id}/delete', 'StatusController@confirm');
		Route::post('/statuses', 'StatusController@store');
		Route::put('/statuses/{id}', 'StatusController@update');
		Route::patch('/statuses/{id}', 'StatusController@update');
		Route::delete('/statuses/{id}', 'StatusController@delete');
	});
		
	// CP > Assets routes
	Route::get('/assets', 'AssetController@index');
	Route::get('/assets/upload', 'AssetController@upload');
	Route::get('/assets/folder/create', 'AssetController@folderCreate');
	Route::get('/assets/folder/delete', 'AssetController@folderConfirm');
	Route::get('/assets/{id}/move', 'AssetController@select');
	Route::get('/assets/{id}/delete', 'AssetController@confirm');
	Route::post('/assets', 'AssetController@store');
	Route::post('/assets/folder', 'AssetController@folderStore');
	Route::put('/assets/{id}/move', 'AssetController@move');
	Route::patch('/assets/{id}/move', 'AssetController@move');
	Route::delete('/assets/folder', 'AssetController@folderDelete');
	Route::delete('/assets/{id}', 'AssetController@delete');
});

// CATCH ALL ROUTE
Route::get('{catchAll}', 'PageController@show')->where('catchAll', '(.*)');
