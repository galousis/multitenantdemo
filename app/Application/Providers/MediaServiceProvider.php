<?php
namespace App\Application\Providers;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Doctrine\Repositories\MediaRepository;
use App\Infrastructure\Media\Filesystem\Filesystem;
use App\Infrastructure\Media\Filesystem\DefaultFilesystem;

/**
 * Class MediaServiceProvider
 *
 * @package App\Application\Providers
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class MediaServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('App\Domain\Media\Contracts\MediaRepositoryContract', 'App\Infrastructure\Doctrine\Repositories\MediaRepository');

//		$this->app->singleton(MediaRepository::class, function () {
//			$mediaClass = $this->app['config']['medialibrary']['media_model'];
//
//			return new MediaRepository(new $mediaClass);
//		});

		$this->app->bind(Filesystem::class, DefaultFilesystem::class);
	}

}