<?php
namespace App\Interfaces\Console\Commands;

use Illuminate\Console\Command as Command;
use Symfony\Component\Console\Input\InputOption as InputOption;
use Symfony\Component\Console\Input\InputArgument as InputArgument;
use Config, DB;

/**
 * Class ResetTenantDatabaseCommand
 *
 * @package App\Interfaces\Console\Commands
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class ResetTenantDatabaseCommand extends Command {

	#region properties
	/**
	 * The name and signature of the console command.
	 * @var string
	 */
	protected $signature = 'migrate:tenant:reset';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = '"migrate:reset" tenant database.';
	#endregion

	#region Constructor
	/**
	 * ResetTenantDatabaseCommand constructor.
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	#endregion

	#region methods
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$connectionName = $this->argument('connection-name');
		$databaseName 	= $this->argument('database-name');
		
		Config::set('database.connections.'.$connectionName.'.database', $databaseName);
		$connection = DB::reconnect($connectionName);
		DB::setDefaultConnection($connectionName);

		$this->info('Creating migration table in tenant database "'.$databaseName.'"...');
		$this->call('migrate:reset');
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
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}
	#endregion
}
