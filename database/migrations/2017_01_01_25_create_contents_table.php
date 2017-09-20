<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();
		 
		Schema::create('contents', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
			
			$table->increments('id');

			$table->unsignedInteger('field_id')->index()->comment('Foreign key to the fields table');
			
			$table->longText('data')->nullable();
			
			$table->timestamps();
		});
		
		Schema::table('contents', function (Blueprint $table) {
			$table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('contents');
	}
}
