<?php
namespace App\Infrastructure\Application\Tenant\Migrations;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Console\Commands\InstallTenantMigrationRepositoryCommand;
use App\Interfaces\Console\Commands\MigrateTenantDabataseCommand;
use App\Interfaces\Console\Commands\RefreshTenantDatabaseCommand;
use App\Interfaces\Console\Commands\ResetTenantDatabaseCommand;
use App\Interfaces\Console\Commands\RollbackTenantDatabaseCommand;
use App\Interfaces\Console\Commands\SeedTenantDatabaseCommand;
use App\Interfaces\Console\Commands\MigrateAllTenantDatabasesCommand;

/**
 * Class TenantMigrateServiceProvider
 *
 * @package App\Infrastructure\Application\Tenant\Migrations
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TenantMigrateServiceProvider extends ServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 * @return void
	 */
	public function boot()
	{
		$this->app->bind('tenancy::command.migrate.tenant.install', function($app){
			return new InstallTenantMigrationRepositoryCommand();
		});
		$this->app->bind('tenancy::command.migrate.tenant', function($app){
			return new MigrateTenantDabataseCommand();
		});
		$this->app->bind('tenancy::command.migrate.tenant.refresh', function($app){
			return new RefreshTenantDatabaseCommand();
		});
		$this->app->bind('tenancy::command.migrate.tenant.reset', function($app){
			return new ResetTenantDatabaseCommand();
		});
		$this->app->bind('tenancy::command.migrate.tenant.rollback', function($app){
			return new RollbackTenantDatabaseCommand();
		});
		$this->app->bind('tenancy::command.db.tenant.seed', function($app){
			return new SeedTenantDatabaseCommand();
		});
		$this->app->bind('tenancy::command.migrate.tenant.all', function($app){
			return new MigrateAllTenantDatabasesCommand();
		});

		$this->commands([
			'tenancy::command.migrate.tenant.install',
			'tenancy::command.migrate.tenant',
			'tenancy::command.migrate.tenant.refresh',
			'tenancy::command.migrate.tenant.reset',
			'tenancy::command.migrate.tenant.rollback',
			'tenancy::command.db.tenant.seed',
			'tenancy::command.migrate.tenant.all',
		]);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}