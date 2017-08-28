<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('assets', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
			
			$table->increments('id');
			
			$table->string('mime_type', 128)->index();
			$table->string('extension', 32)->index();
			$table->string('disk', 32);
            $table->string('directory');
            $table->string('filename');
            $table->string('aggregate_type', 32)->index();
        	
			$table->unsignedInteger('size');
			
			$table->timestamps();
			
			$table->index(['disk', 'directory']);
            $table->unique(['disk', 'directory', 'filename', 'extension']);
        });

		Schema::table('assets', function (Blueprint $table) {
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('assets');
	}
}
