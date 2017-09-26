<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

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
	
	// Webhooks routes
	Route::group(['prefix' => 'webhooks'], function () {
		Route::post('/products', 'ProductController@webhook');
		
		Route::post('/orders', 'OrderController@webhook');
		
		Route::post('/locations', 'LocationController@webhook');
		
		Route::post('/users', 'UserController@webhook');
	});
});
