<?php
namespace App\Interfaces\Console;

use Illuminate\Console\Command;
use App\Domain\User\Entities\User;
use Config;

/**
 * Class UserTableSeed
 *
 * @package App\Interfaces\Console
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserTableSeed extends Command
{

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'users:seed';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Seed users.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{

//		$tenants = Config::get('app.manual_tenants');
//
//		if (count($tenants) >0)
//		{
//			foreach ($tenants as $key => $tenant) {
//
//				if ($key != env('DOMAIN_NAME'))
//				{
//
//					$this->call('migrate', [
//						'--path' => '../../database/migrations/2014_10_12_000000_create_users_table.php',
//					]);
//
//					$this->call('db:seed', [
//						'--class' => 'UsersTableSeeder',
//						'--database' => $key.'_mysql'
//					]);
//				}
//
//
//			}
//		}


	}

}