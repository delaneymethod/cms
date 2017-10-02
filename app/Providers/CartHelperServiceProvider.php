<?php 
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 	
namespace App\Providers;

use App\Helpers\CartHelper;
use Illuminate\Support\ServiceProvider;

class CartHelperServiceProvider extends ServiceProvider 
{
	public function register()
	{
		$this->app->singleton('helpers.cart', function ($app) {
			return new CartHelper($app);
		});
	}
}
