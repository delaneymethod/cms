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

Route::post('/cp/users', 'UserController@store');

Route::put('/cp/users/{id}', 'UserController@update');
Route::patch('/cp/users/{id}', 'UserController@update');

Route::delete('/cp/users/{id}', 'UserController@delete');

// CP > Locations routes
Route::get('/cp/locations', 'LocationController@index');

// CP > Orders routes
Route::get('/cp/orders', 'OrderController@index');

// CP > Articles routes
Route::get('/cp/articles', 'ArticleController@index');

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

// CP > Permissions routes
Route::get('/cp/advanced/permissions', 'PermissionController@index');

// CP > Statuses routes
Route::get('/cp/advanced/statuses', 'StatusController@index');

// CP > Assets routes
Route::get('/cp/assets', 'AssetController@index');
Route::get('/cp/assets/upload', 'AssetController@upload');

Route::post('/cp/assets', 'AssetController@store');
