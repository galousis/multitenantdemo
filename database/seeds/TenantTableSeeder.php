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

		$dbNames = DB::select('show databases;');

		foreach ($dbNames as $dbName)
		{

			if ($dbName == env('DOMAIN_NAME'))
			{
				DB::table('tenants')->insert([
					'sub_domain' => env('APP_NAME'),
					'alias_domain' => env('APP_NAME'),
					'connection' => 'mysql',
					'meta' => '',
					'database' 	 => $dbName,
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
				]);
			}
			else
			{

				$prefixLength 	= strlen(env('DB_NAME_PREFIX'));
				$dbNameStart 	= substr($dbName, 0, $prefixLength);

				DB::table('tenants')->insert([
					'sub_domain' => strtolower($dbNameStart),
					'alias_domain' => strtolower($dbNameStart),
					'connection' => 'tenant_db',
					'meta' => '',
					'database' 	 => $dbName,
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
				]);
			}
		}
	}
}
