<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandardOrganisationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('standard_organisations', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

			$table->unsignedInteger('id')->primary();
			
			$table->string('title')->nullable()->index();
			$table->string('website')->nullable();
			
			$table->longText('description')->nullable();
			
			$table->string('timecheck')->nullable();
			
			$table->timestamps();
		});

		Schema::table('standard_organisations', function (Blueprint $table) {
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('standard_organisations');
	}
}
