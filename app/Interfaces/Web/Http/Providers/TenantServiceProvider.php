<?php
namespace App\Interfaces\Web\Http\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class TenantServiceProvider
 *
 * @package App\Interfaces\Web\Http\Providers
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TenantServiceProvider extends ServiceProvider
{

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('App\Domain\Tenant\Contracts\TenantRepositoryContract', 'App\Infrastructure\Doctrine\Repositories\TenantRepository');
	}



}