<?php
namespace App\Interfaces\Console\Commands;

use Illuminate\Console\Command as Command;
use Symfony\Component\Console\Input\InputOption as InputOption;
use Symfony\Component\Console\Input\InputArgument as InputArgument;
use Config, DB;

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
	protected $signature = 'db:tenant:seed {connection-name} {database-name}';

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
		$databaseName 	= $this->argument('database-name');
//		$className 		= $this->option('class');

		DB::setDefaultConnection($connectionName);

		$tenantDbNames = $this->getTenantDbNames(env('DB_NAME_PREFIX'));

		foreach ($tenantDbNames as $tenantDbName)
		{
//			Config::set('database.connections.'.$connectionName.'.database', $tenantDbName);
//			$connection = DB::reconnect($connectionName);
//			DB::setDefaultConnection($connectionName);

			try {

				$this->info('Seeding tenant database "'.$tenantDbName.'"... "'.$connectionName.'"  ');
				$this->call('db:seed',['--database' => 'tenant_db']);

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
