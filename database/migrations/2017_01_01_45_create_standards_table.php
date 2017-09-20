<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandardsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('standards', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

			$table->unsignedInteger('id')->primary();
			
			$table->string('title')->nullable()->index();
			$table->string('code')->nullable();
			
			$table->longText('further_details')->nullable();
			
			$table->unsignedInteger('standard_organisation_id')->nullable()->index()->comment('Foreign key to the standard organisations table');
			
			$table->timestamps();
		});

		Schema::table('standards', function (Blueprint $table) {
			$table->foreign('standard_organisation_id')->references('id')->on('standard_organisations')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('standards');
	}
}
