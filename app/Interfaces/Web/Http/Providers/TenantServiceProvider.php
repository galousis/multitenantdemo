<?php
namespace App\Interfaces\Web\Http\Providers;

use Illuminate\Support\ServiceProvider;
use App\Application\Services\Tenant\TenantResolveService;

/**
 * Class TenantServiceProvider
 *
 * @package App\Interfaces\Web\Http\Providers
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TenantServiceProvider extends ServiceProvider
{

	public function boot()
	{
		/** @var TenantResolveService $resolver */
		$resolver = app('tenant');
		$resolver->resolveTenant();
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('App\Domain\Tenant\Contracts\TenantRepositoryContract', 'App\Infrastructure\Doctrine\Repositories\TenantRepository');

		$this->app->singleton('tenant', function($app)
		{
			$tenant = app('App\Domain\Tenant\Contracts\TenantRepositoryContract');
			return new TenantResolveService($app, $tenant);
		});
	}



}