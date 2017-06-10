<?php

namespace App\Interfaces\Web\Http\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Domain\Tenant\Entities\Tenant;
use App\Application\Services\Tenant\Access\TenantService;
use Illuminate\Http\Request;

/**
 * Class RouteServiceProvider
 *
 * @package App\Interfaces\Web\Http\Providers
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class RouteServiceProvider extends ServiceProvider
{
	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	//protected $namespace = 'App\Application\Http\Controllers';

	protected $api_namespace = 'App\Interfaces\Api\Http\Controllers';
	protected $web_namespace = 'App\Interfaces\Web\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
		parent::boot();

		#explicit bind to entity Tenant
//		Route::bind('domain', function ($value) {
//
//			if($value)
//			{
//				/** @var Tenant $domain */
//				$domain= TenantService::whereSubdomain($value)->first();
//				if ($domain) {
//					switch ($domain->getSubDomain()) {
//						case "gr":
//							return env('GR_DOMAIN');
//							break;
//						case "uk":
//							return env('UK_DOMAIN');
//							break;
//						case "us":
//							return env('US_DOMAIN');
//							break;
//					}
//				}
//			}
//			else{
//				return env('APP_DOMAIN');
//			}
//		});
	}
	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map()
	{
		$this->mapApiRoutes();
		$this->mapWebRoutes();
		//
	}
	/**
	 * Define the "web" routes for the application.
	 *
	 * These routes all receive session state, CSRF protection, etc.
	 *
	 * @return void
	 */
	protected function mapWebRoutes()
	{
		Route::group([
			'middleware' => 'web',
			'namespace' => $this->web_namespace,
		], function ($router) {
			require base_path('app/Application/Routes/web.php');
		});
	}
	/**
	 * Define the "api" routes for the application.
	 *
	 * These routes are typically stateless.
	 *
	 * @return void
	 */
	protected function mapApiRoutes()
	{
		Route::group([
			'middleware' => ['throttle:30:5','cors'],
			'namespace' => $this->api_namespace,
			'prefix' => 'api/v1',
		], function ($router) {
			require base_path('app/Application/Routes/api.php');
		});
	}
}