<?php

namespace App\Interfaces\Web\Http\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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
			'middleware' => 'api',
			'namespace' => $this->api_namespace,
			'prefix' => 'api',
		], function ($router) {
			require base_path('app/Application/Routes/api.php');
		});
	}
}