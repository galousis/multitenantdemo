<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
	static $password;

	/**
	 * Run the database seeds.
	 *
	 * @return  void
	 */
	public function run()
	{
		$curentDBName = Config::get('database.connections.'.Config::get('database.default').'.database');

		if ($curentDBName != env('DOMAIN_NAME')) // Seed only tenants not master
		{
			//Drop the users table
			DB::table('users')->truncate();

			$faker = Faker\Factory::create();

			for ($x = 0; $x <= 4; $x++) {

				$this->ResetPassword();

				DB::table('users')->insert([
					'name' => "{$faker->firstName} {$faker->lastName}",
					'email' => $faker->unique()->safeEmail,
					'password' => $this->GetPassword() ?: $this::$password = bcrypt('secret'),
					'remember_token' => str_random(10),
					'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
				]);
			}
		}

	}

	public function ResetPassword()
	{
		$this::$password = null;
	}

	/**
	 * @return mixed
	 */
	public function GetPassword()
	{
		return $this::$password;
	}

}