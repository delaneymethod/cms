<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('counties', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

			$table->increments('id');

			$table->string('title')->index();
			
			$table->unsignedInteger('country_id')->index()->nullable()->comment('Foreign key to the countries table');
			
			$table->timestamps();
		});

		Schema::table('counties', function (Blueprint $table) {
			$table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('counties');
	}
}