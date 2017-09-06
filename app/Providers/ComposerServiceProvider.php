<?php

namespace App\Providers;

use App\Http\Traits\PageTrait;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
	use PageTrait;
	
	/**
	 * Register bindings in the container.
	 *
	 * @return void
	 */
	public function boot()
	{
		View::composer('*', function ($view) {
			$view->with('pages', $this->getPages());
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
	}
}
