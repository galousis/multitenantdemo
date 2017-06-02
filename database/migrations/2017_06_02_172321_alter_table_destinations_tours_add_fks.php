<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableDestinationsToursAddFks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('destinations_tours', function(Blueprint $table)
		{

			// foreign keys
			$table->foreign('tour_id')
				->references('id')->on('tours')
				->onUpdate('cascade')
				->onDelete('cascade');

			$table->foreign('destination_id')
				->references('id')->on('destinations')
				->onUpdate('cascade')
				->onDelete('cascade');

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
