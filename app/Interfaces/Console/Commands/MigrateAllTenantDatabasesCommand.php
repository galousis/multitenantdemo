<?php
namespace App\Interfaces\Console\Commands;

use \Illuminate\Console\Command as Command;
use \Illuminate\Database\QueryException as QueryException;
use \Symfony\Component\Console\Input\InputOption as InputOption;
use \Symfony\Component\Console\Input\InputArgument as InputArgument;
use DB;

/**
 * Class MigrateAllTenantDatabasesCommand
 *
 * @package App\Interfaces\Console\Commands
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class MigrateAllTenantDatabasesCommand extends Command {

	#region properties
	/**
	 * The name and signature of the console command.
	 * @var string
	 */
	protected $signature = 'migrate:tenant:all {connection-name} {database-prefix}';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = 'Migrate all tenant databases.';
	#endregion

	#region Methods
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle(){

		$connectionName = $this->argument('connection-name');
		$databasePrefix = $this->argument('database-prefix');

		DB::setDefaultConnection($connectionName);

		$tenantDbNames = $this->getTenantDbNames($databasePrefix);

		foreach ($tenantDbNames as $tenantDbName)
		{
//			try {
//
//				$this->call ('migrate:tenant:install',['connection-name' => $connectionName,'database-name' => $tenantDbName,]);
//
//			}
//			catch (QueryException $e) {
//				if($e->getCode() != '42S01')
//					throw $e;
//				$this -> info ('Migration table already created.');
//			}

			try {

				$this -> call('migrate:tenant',['connection-name' => $connectionName,'database-name' => $tenantDbName,]);

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
			array('database-prefix', InputArgument::REQUIRED, 'Tenant database name.'),
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
