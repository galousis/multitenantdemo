<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class DestinationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$curentDBName = Config::get('database.connections.'.Config::get('database.default').'.database');

		if ($curentDBName != env('DOMAIN_NAME')) // Seed only tenants not master
		{
//			//Drop the destinations table
//			DB::table('destinations')->truncate();

			$faker = Faker\Factory::create();

			/** @var Connection $connection */
			$connection = Schema::getConnection();

			$dbName = $connection->getDatabaseName();

			$prefixLength = strlen(env('DB_NAME_PREFIX'));
			$dbNameStart = substr($dbName, $prefixLength, 2);

			for ($x = 0; $x <= 10; $x++) {

				DB::table('destinations')->insert([
					'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
					'country' => $dbNameStart,
					'description' => $faker->paragraph($nbSentences = 6, $variableNbSentences = true),
					'lat' => $faker->latitude,
					'lng' => $faker->longitude,
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
				]);
			}
		}
    }
}
