<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', 'ApiController@index');

Route::prefix('v1')->group(function () {
	Route::get('/', 'ApiController@index');
	
	// Ping routes
	Route::get('/ping', 'ApiController@ping');
	
	// Event routes
	Route::group(['prefix' => 'events'], function () {
		Route::post('/order', 'OrderController@event');
		
		Route::post('/location', 'LocationController@event');
		
		Route::post('/user', 'UserController@event');
	});
});
