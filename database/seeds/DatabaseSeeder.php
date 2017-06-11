<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
		$this->call(ToursTableSeeder::class);
		$this->call(DestinationsTableSeeder::class);
		$this->call(DestinationsToursTableSeeder::class);
		$this->call(TenantTableSeeder::class);
		$this->call(DestinationsMediaSeeder::class);
    }
}
