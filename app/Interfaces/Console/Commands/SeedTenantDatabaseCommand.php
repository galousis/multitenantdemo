<?php
namespace App\Interfaces\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption as InputOption;
use Symfony\Component\Console\Input\InputArgument as InputArgument;
use Config, DB;
use LaravelDoctrine\ORM\IlluminateRegistry;

/**
 * Class SeedTenantDatabaseCommand
 *
 * @package App\Interfaces\Console\Commands
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class SeedTenantDatabaseCommand extends Command {

	#region properties
	/**
	 * The name and signature of the console command.
	 * @var string
	 */
	protected $signature = 'db:tenant:seed {connection-name} {class}';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = '"db:seed" tenant database.';
	#endregion

	#region Constructor
	/**
	 * SeedTenantDatabaseCommand constructor.
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	#endregion

	#region Methods
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$connectionName = $this->argument('connection-name');
//		$databaseName 	= $this->argument('database-name');
		$className 		= $this->argument('class');

		DB::setDefaultConnection($connectionName);

		$tenantDbNames = $this->getTenantDbNames(env('DB_NAME_PREFIX'));

		foreach ($tenantDbNames as $tenantDbName)
		{
//			Config::set('database.connections.tenant_db.database', $tenantDbName);
//			DB::setDefaultConnection('tenant_db');
//			DB::setDatabaseName($tenantDbName);
//			DB::reconnect('tenant_db');

			config()->set('database.default', 'tenant_db');
			config()->set('database.connections.tenant_db.database', $tenantDbName);

			DB::purge(DB::getDefaultConnection());
			DB::setDefaultConnection('tenant_db');

			try {

				$this -> info (PHP_EOL);
				$this -> info (DB::getDatabaseName());
				$this -> info (PHP_EOL);
				$this -> info (DB::getDefaultConnection());
				$this -> info (PHP_EOL);
				$this -> info (Config::get('database.connections.tenant_db.database'));


				$this->info('Seeding tenant database "'.$tenantDbName.'"...');
				$this->call('db:seed',['--class' => $className, '--database' => 'tenant_db']);

			}
			catch(\Exception $e) {
				echo $e -> getMessage().PHP_EOL;
			}

			$this -> info (PHP_EOL);
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('connection-name', InputArgument::REQUIRED, 'Tenant connection name.'),
			array('database-name', InputArgument::REQUIRED, 'Tenant database name.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('class', null, InputOption::VALUE_REQUIRED, 'Seeder class name.', null),
		);
	}

	/**
	 * @param $prefix
	 * @return array
	 */
	private function getTenantDbNames($prefix){

		$prefixLength = strlen($prefix);

		$dbNames = DB::select('show databases;');

		$tenantDbNames = [];

		foreach ($dbNames as $dbName)
		{
			$dbNameStart = substr($dbName->Database, 0, $prefixLength);

			if($dbNameStart === $prefix) {
				$tenantDbNames[] = $dbName->Database;
			}
		}
		return $tenantDbNames;
	}
	#endregion
}
