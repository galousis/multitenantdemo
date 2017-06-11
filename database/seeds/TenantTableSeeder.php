<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Database\Connection;
use Carbon\Carbon;

class TenantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		$curentDBName = Config::get('database.connections.'.Config::get('database.default').'.database');

		if ($curentDBName == env('DOMAIN_NAME')) // Seed only master's DB tenants Table
		{
			//Drop the destinations table
			DB::table('tenants')->truncate();

			$tenantDbNames = $this->getTenantDbNames(env('DB_NAME_PREFIX'));

			foreach ($tenantDbNames as $tenantDbName)
			{

				if ($tenantDbName == env('DOMAIN_NAME'))
				{
					DB::table('tenants')->insert([
						'sub_domain' => env('DB_NAME_PREFIX').'master',
						'alias_domain' => env('DB_NAME_PREFIX').'master',
						'connection' => 'mysql',
						'meta' => '',
						'database' 	 => env('DB_NAME_PREFIX').'master',
						'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
						'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
					]);
				}
				else
				{

					$subDomain = explode('_', $tenantDbName)[1];

					DB::table('tenants')->insert([
						'sub_domain' => strtolower($subDomain),
						'alias_domain' => strtolower($subDomain),
						'connection' => 'tenant_db',
						'meta' => '',
						'database' 	 => $tenantDbName,
						'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
						'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
					]);
				}




			}

		}


	}

	/**
	 * @param $prefix
	 * @return array
	 */
	protected function getTenantDbNames($prefix){

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
}
