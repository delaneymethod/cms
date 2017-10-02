<?php
/**
 * @link	  https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license	  https://www.delaneymethod.com/cms/license
 */

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use App\Models\{Cart, Order, Company, Location};
use App\Policies\{CartPolicy, UserPolicy, OrderPolicy, CompanyPolicy, LocationPolicy};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		User::class => UserPolicy::class,
		Cart::class => CartPolicy::class,
		Order::class => OrderPolicy::class,
		Company::class => CompanyPolicy::class,
		Location::class => LocationPolicy::class,
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();
	}
}
