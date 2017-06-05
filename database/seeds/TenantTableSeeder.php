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

		/** @var Connection $connection */
		$connection = Schema::getConnection();

		$db_name = $connection->getDatabaseName();

		if($db_name == env('DB_DATABASE'))
		{
			//Truncate the tenants table
			DB::table('tenants')->truncate();

			$tenants = Config::get('app.manual_tenants');

			if ($tenants >0)
			{
				foreach ($tenants as $key => $tenant) {

					DB::table('tenants')->insert([
						'sub_domain' => $tenants[$key],
						'database' 	 => env('APP_NAME').'_'.$key,
						'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
						'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
					]);

				}
			}

		}

	}
}
