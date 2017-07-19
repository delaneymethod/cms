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

// Dashboard routes
Route::get('/dashboard', 'DashboardController@index');

// Dashboard > Users routes
Route::get('/dashboard/users', 'UserController@index');
Route::get('/dashboard/users/create', 'UserController@create');
Route::get('/dashboard/users/{id}/edit', 'UserController@edit');

Route::post('/dashboard/users', 'UserController@store');

Route::put('/dashboard/users/{id}', 'UserController@update');
Route::patch('/dashboard/users/{id}', 'UserController@update');

Route::delete('/dashboard/users/{id}', 'UserController@delete');

// Dashboard > Locations routes
Route::get('/dashboard/locations', 'LocationController@index');

// Dashboard > Orders routes
Route::get('/dashboard/orders', 'OrderController@index');

// Dashboard > Articles routes
Route::get('/dashboard/articles', 'ArticleController@index');

// Dashboard > Pages routes
Route::get('/dashboard/pages', 'PageController@index');
Route::get('/dashboard/pages/create', 'PageController@create');
Route::get('/dashboard/pages/{id}/edit', 'PageController@edit');

Route::post('/dashboard/pages', 'PageController@store');

Route::put('/dashboard/pages/{id}', 'PageController@update');
Route::patch('/dashboard/pages/{id}', 'PageController@update');

Route::delete('/dashboard/pages/{id}', 'PageController@delete');

// Dashboard > Menu routes
Route::get('/dashboard/menu', 'PageController@menu');

Route::put('/dashboard/menu', 'PageController@tree');
Route::patch('/dashboard/menu', 'PageController@tree');

// Dashboard > Advanced routes
Route::get('/dashboard/advanced', 'RoleController@index');

// Dashboard > Roles routes
Route::get('/dashboard/advanced/roles', 'RoleController@index');

// Dashboard > Permissions routes
Route::get('/dashboard/advanced/permissions', 'PermissionController@index');

// Dashboard > Statuses routes
Route::get('/dashboard/advanced/statuses', 'StatusController@index');
