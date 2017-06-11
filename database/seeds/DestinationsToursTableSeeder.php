<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Query\Builder;
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
		$curentDBName = Config::get('database.connections.'.Config::get('database.default').'.database');

		if ($curentDBName != env('DOMAIN_NAME')) // Seed only tenants not master
		{
//			//Drop the destinations table
//			DB::table('destinations_tours')->truncate();

			for ($x = 0; $x <= 10; $x++) {
				$this->checkIntegrity();
			}
		}
	}

	/**
	 * Reccursion to check for dublicate entries
	 */
	protected function checkIntegrity()
	{
		$tourIds = DB::table('tours')->select('id')->get()->all();
		shuffle($tourIds);
		$destIds = DB::table('destinations')->select('id')->get()->all();
		shuffle($destIds);

		$destIdsKey = array_rand($tourIds, 1);
		$tourIdsKey = array_rand($destIds, 1);

		/** @var Builder $result */
		$result = DB::table('destinations_tours')
			->where([
				['destination_id', '=', $destIds[$destIdsKey]->id],
				['tour_id', '=', $tourIds[$tourIdsKey]->id]
			]);

		if ($result->get()->count() != 0)
		{
			$this->checkIntegrity();
		}
		else
			{
				DB::table('destinations_tours')->insert([
					'destination_id' => $destIds[$destIdsKey]->id,
					'tour_id' => $tourIds[$tourIdsKey]->id
				]);

		}
	}
}
