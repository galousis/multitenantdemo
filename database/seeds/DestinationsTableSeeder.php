<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
		//Drop the destinations table
		DB::table('destinations')->delete();

		$faker = Faker\Factory::create();

		$input = array("US", "UK", "GR");

		for ($x = 0; $x <= 10; $x++) {

			DB::table('destinations')->insert([
				'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
				'country' => $input[rand( 0 , 2)],
				'description' => $faker->paragraph($nbSentences = 6, $variableNbSentences = true),
				'lat' => $faker->latitude,
				'lng' => $faker->longitude,
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
			]);
		}
    }
}
