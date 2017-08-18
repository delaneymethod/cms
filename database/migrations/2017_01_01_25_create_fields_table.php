<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();
		 
		Schema::create('fields', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
			
			$table->increments('id');

			$table->string('title')->index();
			$table->string('handle');
			$table->string('instructions')->nullable();
			
			$table->unsignedInteger('field_type_id')->index()->comment('Foreign key to the field types table');
			$table->unsignedInteger('required')->default(1);
			
			$table->timestamps();
		});
		
		Schema::table('fields', function (Blueprint $table) {
			$table->foreign('field_type_id')->references('id')->on('field_types')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('fields');
	}
}
