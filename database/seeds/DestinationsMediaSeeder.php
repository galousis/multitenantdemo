<?php

use Illuminate\Database\Seeder;

use App\Domain\Destination\Contracts\DestinationRepositoryContract;
use App\Domain\Destination\Entities\Destination;
use LaravelDoctrine\ORM\IlluminateRegistry;
use App\Infrastructure\Doctrine\Repositories\DestinationRepository;

class DestinationsMediaSeeder extends Seeder
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
			DB::table('media')->truncate();

			$faker = Faker\Factory::create();

			//TODO will call TenantResolveService to do resolve from cli with registerTenantConsoleArgument (app running in console)
			//TODO for the moment leave it as below

			#region Doctrine
			/** @var IlluminateRegistry $registry */
			$registry = app()->make('registry');

			$subDomain = strtolower(explode('_', $curentDBName)[1]);

			if (!$registry->managerExists($subDomain))
			{
				// Prepare settings, grab them from doctrine conf so we get the Fluent mappings too.
				$settings = Config::get('doctrine.managers.default');
				// Ooops set the tenant_db as connection, otherwise nana will work properly bellow
				$settings['connection'] = Config::get('database.default');

				// Now we need to add the dynamic manager (does not exists in doctrine config file)
				// into conatiner's registry (IlluminateRegistry), adds the connection too for us !
				$registry->addManager($subDomain, $settings );
			}

			// Set defaults
			$registry->setDefaultManager($subDomain);
			$registry->setDefaultConnection($subDomain);
			#endregion


			$result = DB::table('destinations')->get(['id']);

			if ($result->count() > 0)
			{
				/** @var DestinationRepository $destRepo */
				$destRepo = new DestinationRepository($registry->getManager($subDomain));
			}


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

					$mediaRepo = new \App\Infrastructure\Doctrine\Repositories\MediaRepository($registry->getManager($subDomain));

					$destination->addMedia($fakeImage)->preservingOriginal()->toMediaCollection('featured', 'local', $mediaRepo);
				}

			}
		}
	}
}
