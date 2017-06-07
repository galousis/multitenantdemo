<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Connection;

class AddExtraColumnsToTenantTable extends Migration
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

			Schema::table('tenants', function (Blueprint $table) {

				$table->string('alias_domain')->unique()->nullable()->after('sub_domain');
				$table->string('connection')->after('alias_domain');
				$table->text('meta')->nullable()->after('connection');

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
		/** @var Connection $connection */
		$connection = Schema::getConnection();

		$db_name = $connection->getDatabaseName();

		if($db_name == env('DB_DATABASE'))
		{

			Schema::table('tenants', function (Blueprint $table) {

				$table->dropColumn('alias_domain');
				$table->dropColumn('connection');
				$table->dropColumn('meta');

			});
		}
    }
}
