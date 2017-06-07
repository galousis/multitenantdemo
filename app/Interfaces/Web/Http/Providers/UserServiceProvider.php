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
		$this->app->bind('App\Domain\User\Contracts\AuthentifierContract', 'App\Domain\User\Authentifier');
		$this->app->bind('App\Domain\User\Contracts\UserRepositoryContract', 'App\Infrastructure\Doctrine\Repositories\UserRepository');
		$this->app->bind('App\Domain\Destination\Contracts\DestinationRepositoryContract', 'App\Infrastructure\Doctrine\Repositories\DestinationRepository');
		$this->app->bind('App\Domain\Tour\Contracts\TourRepositoryContract', 'App\Infrastructure\Doctrine\Repositories\TourRepository');
		$this->app->bind('App\Application\Services\DataTransformer\User\UserDataTransformer', 'App\Application\Services\DataTransformer\User\UserTransformer');
	}
}