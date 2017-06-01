<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('destinations', function (Blueprint $table) {

			$table->increments('id');
			$table->string('title')->default('')->comment('Destination title');
			$table->string('country', 3)->default('')->comment('Destination country');
			$table->text('description')->comment('Destination description');
			$table->float('lat', 10, 6)->nullable();
			$table->float('lng', 10, 6)->nullable();
			$table->timestamps();

			//indeces
			$table->index('country');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('destinations');
	}
}
