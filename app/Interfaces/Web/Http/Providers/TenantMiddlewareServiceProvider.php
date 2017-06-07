<?php
namespace App\Interfaces\Web\Http\Providers;

use App\Application\Services\Tenant\TenantResolveService;
use App\Interfaces\Web\Http\Providers\TenantServiceProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Class TenantMiddlewareServiceProvider
 *
 * @package App\Interfaces\Web\Http\Providers
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TenantMiddlewareServiceProvider extends TenantServiceProvider
{
	/**
	 * This function overrides the TenantServiceProvider class.
	 *
	 * Instead of trying to resolve the tenant upon boot
	 * it only adds in a middleware alias that will
	 * check when added to any route.
	 */
	public function boot()
	{
		$this->app['router']->aliasMiddleware('tenantResolver', TenantResolveService::class);
	}
}