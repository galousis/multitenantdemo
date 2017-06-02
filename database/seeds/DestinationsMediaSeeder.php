<?php

use Illuminate\Database\Seeder;

use App\Domain\Destination\Contracts\DestinationRepositoryContract;
use App\Domain\Destination\Entities\Destination;

class DestinationsMediaSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//DB::table('media')->truncate();

		$faker = Faker\Factory::create();

		/** @var DestinationRepositoryContract $destRepo */
		$destRepo = app()->make('App\Domain\Destination\Contracts\DestinationRepositoryContract');

		$allDest = $destRepo->findAll();

		foreach ($allDest as $dest) {

			/** @var Destination $destination */
			$destination = $dest;

			$counter = 0;
			// max retries = 5 because sometimes faker return false
			while (!($fakeImage = $faker->image(null, 600, 400)) && ($counter < 5)) {
				$counter++;
			}

			if ($fakeImage !== false) {
				$destination->addMedia($fakeImage)->preservingOriginal()->toMediaCollection('featured', 'local');
			}

		}

	}
}
