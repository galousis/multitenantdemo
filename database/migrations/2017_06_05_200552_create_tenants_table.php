<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Connection;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    	/** @var Connection $connection */
		$connection = Schema::getConnection();

		$db_name = $connection->getDatabaseName();

		if($db_name == env('DB_DATABASE'))
		{

			Schema::create('tenants', function (Blueprint $table) {

				$table->increments('id');
				$table->string('sub_domain', 150)->default('')->comment('Subdomain');
				$table->string('database', 50)->default('')->comment('Tenant db');
				$table->timestamps();

				//indeces
				$table->index('sub_domain');
			});
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('tenants');
    }
}
