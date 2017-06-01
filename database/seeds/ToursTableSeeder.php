<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Hashids\Hashids;

class ToursTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//Drop the destinations table
		DB::table('tours')->delete();

		$faker = Faker\Factory::create();

		for ($x = 0; $x <= 10; $x++) {


			$hashids 	= new Hashids('this is my constant salt', 5,'abcdefghijklmnpqrstuvwxyz0123456789');
			$hash 		= $hashids->encode($x);

			$int	= mt_rand(1496348415,1498854015);
			$date 	= date("Y-m-d H:i:s",$int);

			DB::table('tours')->insert([
				'tour_code' => $hash,
				'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
				'description' => $faker->paragraph($nbSentences = 6, $variableNbSentences = true),
//				'departure' => Carbon::createFromDate(2017, 6, 15, \DateTimeZone::EUROPE),
				'departure' => $date,
				'duration' => rand( 1 , 4),
				'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
			]);
		}
	}
}
