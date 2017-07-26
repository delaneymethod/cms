<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('locations', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

			$table->increments('id');

			$table->string('title')->index();
			$table->string('unit')->nullable();
			$table->string('building')->nullable();
			$table->string('street_address_1')->index();
			$table->string('street_address_2')->nullable();
			$table->string('street_address_3')->nullable();
			$table->string('street_address_4')->nullable();
			$table->string('town_city')->index();
			$table->string('postal_code')->nullable();
			$table->string('telephone');
			
			$table->unsignedInteger('county_id')->nullable()->index()->comment('Foreign key to the counties table');
			$table->unsignedInteger('country_id')->nullable()->index()->comment('Foreign key to the countries table');
			$table->unsignedInteger('company_id')->nullable()->index()->comment('Foreign key to the companies table');
			$table->unsignedInteger('status_id')->nullable()->index()->comment('Foreign key to the statuses table');
			
			$table->timestamps();
		});

		Schema::table('locations', function (Blueprint $table) {
			$table->foreign('county_id')->references('id')->on('counties')->onDelete('set null');
			$table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
			$table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
			$table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('locations');
	}
}
