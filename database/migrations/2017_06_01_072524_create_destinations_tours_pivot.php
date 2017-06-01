<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinationsToursPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//Schema::dropIfExists('destinations_tours');
		Schema::create('destinations_tours', function(Blueprint $table)
		{
			$table->integer('destination_id')->unsigned();
			$table->integer('tour_id')->unsigned();
			// setup index
			$table->primary(array('destination_id', 'tour_id'));
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
