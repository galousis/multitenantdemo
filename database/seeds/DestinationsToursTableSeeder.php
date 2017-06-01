<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Hashids\Hashids;

class DestinationsToursTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Drop the destinations table
		DB::table('destinations_tours')->delete();

		$faker = Faker\Factory::create();

		for ($x = 0; $x <= 10; $x++) {

			$tourIds = DB::table('tours')->select('id')->get()->all();

			$destIds = DB::table('destinations')->select('id')->get()->all();

			$destIdsKey = array_rand($destIds, 1);

			$tourIdsKey = array_rand($tourIds, 1);


			DB::table('destinations_tours')->insert([
				'destination_id' => $destIds[$destIdsKey]->id,
				'tour_id' => $tourIds[$tourIdsKey]->id
			]);


		}
	}
}
