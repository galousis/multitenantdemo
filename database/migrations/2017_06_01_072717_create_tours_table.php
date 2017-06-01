<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('tours', function (Blueprint $table) {

			$table->increments('id');
			$table->string('tour_code', 5)->default('')->comment('Tour code');
			$table->string('title')->default('')->comment('Tour title');
			$table->string('description')->default('')->comment('Tour description');
			$table->dateTimeTz('departure');
			$table->tinyInteger('duration');
			$table->timestamps();

			//indeces
			$table->index('tour_code');

		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('tours');
    }
}
