<?php
namespace App\Interfaces\Web\Http\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class UserServiceProvider
 *
 * @package App\Interfaces\Web\Http\Providers
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('App\Domain\User\Contracts\UserRepositoryContract', 'App\Infrastructure\Doctrine\Mappings\Repositories\UserRepository');
	}
}