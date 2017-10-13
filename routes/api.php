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
	
	
	
	
	// TEST COMPANIES ENDPOINT - REMOVE ONCE REAL API IS READY
	Route::post('/companies', function (Illuminate\Http\Request $request) {
		Log::info('');
		Log::info('---- Processed Company ----');
		Log::info('');
		
		return response()->json(['message' => 'Processed Company'], 200, []);
	});
	
	// TEST LOCATIONS ENDPOINT - REMOVE ONCE REAL API IS READY
	Route::post('/locations', function (Illuminate\Http\Request $request) {
		Log::info('');
		Log::info('---- Processed Location ----');
		Log::info('');
		
		return response()->json(['message' => 'Processed Location'], 200, []);
	});
	
	// TEST USERS ENDPOINT - REMOVE ONCE REAL API IS READY
	Route::post('/users', function (Illuminate\Http\Request $request) {
		Log::info('');
		Log::info('---- Processed User ----');
		Log::info('');
		
		return response()->json(['message' => 'Processed User'], 200, []);
	});
	
	// TEST ORDERS ENDPOINT - REMOVE ONCE REAL API IS READY
	Route::post('/orders', function (Illuminate\Http\Request $request) {
		Log::info('');
		Log::info('---- Processed Order ----');
		Log::info('');
		
		return response()->json(['message' => 'Processed Order'], 200, []);
	});
	
	// TEST PRODUCT COMMMODITIES PRICING ENDPOINT - REMOVE ONCE REAL API IS READY
	Route::get('/product-commodities/pricing/{code}', function (Illuminate\Http\Request $request, string $code) {
		
		// Real API would accept our Product Commodity Code, do a look and return back the data
		$max = 100.0;
		
		$min = 0.5;

		$range = $max - $min;
		
		$num = $min + $range * (mt_rand() / mt_getrandmax());    
		
		$price = (float) round($num, 2);
	
		return response()->json([
			'price' => $price,
			'price_per' => 1,
			'quantity_available' => mt_rand(0, 500),
		], 200, []);
	});
	// TEST ORDERS ENDPOINT - REMOVE ONCE REAL API IS READY
	
	
	
});
