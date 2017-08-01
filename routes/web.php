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

Route::get('/', 'HomeController@index');

// CP route
Route::get('/cp', function () {
	return redirect('/cp/dashboard');
});

// CP > Dashboard routes
Route::get('/cp/dashboard', 'DashboardController@index');

// CP > Users routes
Route::get('/cp/users', 'UserController@index');
Route::get('/cp/users/create', 'UserController@create');
Route::get('/cp/users/{id}/edit', 'UserController@edit');
Route::get('/cp/users/{id}/edit/password', 'UserController@editPassword');
Route::get('/cp/users/{id}/retire', 'UserController@retire');
Route::get('/cp/users/{id}/delete', 'UserController@confirm');
Route::post('/cp/users', 'UserController@store');
Route::put('/cp/users/{id}', 'UserController@update');
Route::patch('/cp/users/{id}', 'UserController@update');
Route::delete('/cp/users/{id}', 'UserController@delete');

// CP > Companies routes
Route::get('/cp/companies', 'CompanyController@index');
Route::get('/cp/companies/create', 'CompanyController@create');
Route::get('/cp/companies/{id}/edit', 'CompanyController@edit');
Route::get('/cp/companies/{id}/delete', 'CompanyController@confirm');
Route::post('/cp/companies', 'CompanyController@store');
Route::put('/cp/companies/{id}', 'CompanyController@update');
Route::patch('/cp/companies/{id}', 'CompanyController@update');
Route::delete('/cp/companies/{id}', 'CompanyController@delete');

// CP > Locations routes
Route::get('/cp/locations', 'LocationController@index');
Route::get('/cp/locations/create', 'LocationController@create');
Route::get('/cp/locations/{id}/edit', 'LocationController@edit');
Route::get('/cp/locations/{id}/retire', 'LocationController@retire');
Route::get('/cp/locations/{id}/delete', 'LocationController@confirm');
Route::post('/cp/locations', 'LocationController@store');
Route::put('/cp/locations/{id}', 'LocationController@update');
Route::patch('/cp/locations/{id}', 'LocationController@update');
Route::delete('/cp/locations/{id}', 'LocationController@delete');

// CP > Orders routes
Route::get('/cp/orders', 'OrderController@index');
Route::get('/cp/orders/{id}/edit', 'OrderController@edit');
Route::get('/cp/orders/{id}/delete', 'OrderController@confirm');
Route::put('/cp/orders/{id}', 'OrderController@update');
Route::patch('/cp/orders/{id}', 'OrderController@update');
Route::delete('/cp/orders/{id}', 'OrderController@delete');

// CP > Articles routes
Route::get('/cp/articles', 'ArticleController@index');
Route::get('/cp/articles/create', 'ArticleController@create');
Route::get('/cp/articles/{id}/edit', 'ArticleController@edit');
Route::get('/cp/articles/{id}/delete', 'ArticleController@confirm');
Route::post('/cp/articles', 'ArticleController@store');
Route::put('/cp/articles/{id}', 'ArticleController@update');
Route::patch('/cp/articles/{id}', 'ArticleController@update');
Route::delete('/cp/articles/{id}', 'ArticleController@delete');

// CP > Pages routes
Route::get('/cp/pages', 'PageController@index');
Route::get('/cp/pages/create', 'PageController@create');
Route::get('/cp/pages/{id}/edit', 'PageController@edit');
Route::get('/cp/pages/{id}/delete', 'PageController@confirm');
Route::post('/cp/pages', 'PageController@store');
Route::put('/cp/pages/{id}', 'PageController@update');
Route::patch('/cp/pages/{id}', 'PageController@update');
Route::delete('/cp/pages/{id}', 'PageController@delete');

// CP > Menu routes
Route::get('/cp/menu', 'PageController@menu');
Route::put('/cp/menu', 'PageController@tree');
Route::patch('/cp/menu', 'PageController@tree');

// CP > Advanced routes
Route::get('/cp/advanced', 'RoleController@index');

// CP > Roles routes
Route::get('/cp/advanced/roles', 'RoleController@index');
Route::get('/cp/advanced/roles/create', 'RoleController@create');
Route::get('/cp/advanced/roles/{id}/edit', 'RoleController@edit');
Route::get('/cp/advanced/roles/{id}/delete', 'RoleController@confirm');
Route::post('/cp/advanced/roles', 'RoleController@store');
Route::post('/cp/advanced/roles/permissions', 'RoleController@permissions');
Route::put('/cp/advanced/roles/{id}', 'RoleController@update');
Route::patch('/cp/advanced/roles/{id}', 'RoleController@update');
Route::delete('/cp/advanced/roles/{id}', 'RoleController@delete');

// CP > Permissions routes
Route::get('/cp/advanced/permissions', 'PermissionController@index');

// CP > Statuses routes
Route::get('/cp/advanced/statuses', 'StatusController@index');
Route::get('/cp/advanced/statuses/create', 'StatusController@create');
Route::get('/cp/advanced/statuses/{id}/edit', 'StatusController@edit');
Route::get('/cp/advanced/statuses/{id}/delete', 'StatusController@confirm');
Route::post('/cp/advanced/statuses', 'StatusController@store');
Route::put('/cp/advanced/statuses/{id}', 'StatusController@update');
Route::patch('/cp/advanced/statuses/{id}', 'StatusController@update');
Route::delete('/cp/advanced/statuses/{id}', 'StatusController@delete');

// CP > Assets routes
Route::get('/cp/assets', 'AssetController@index');
Route::get('/cp/assets/upload', 'AssetController@upload');
Route::post('/cp/assets', 'AssetController@store');
