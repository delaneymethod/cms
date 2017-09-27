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
			$table->string('handle')->index();
			$table->string('instructions')->nullable();
			
			$table->mediumText('options')->nullable();
			
			$table->unsignedInteger('field_type_id')->index()->comment('Foreign key to the field types table');
			$table->unsignedInteger('required')->default(0);
			
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});
		
		Schema::table('fields', function (Blueprint $table) {
			$table->foreign('field_type_id')->references('id')->on('field_types')->onDelete('cascade');
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
