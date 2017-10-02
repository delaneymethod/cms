<?php 
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 	
namespace App\Providers;

use App\Helpers\DirectoryHelper;
use Illuminate\Support\ServiceProvider;

class DirectoryHelperServiceProvider extends ServiceProvider 
{
	public function register()
	{
		$this->app->singleton('helpers.directory', function ($app) {
			return new DirectoryHelper($app);
		});
	}
}
