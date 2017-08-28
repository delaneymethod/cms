<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediablesTables extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();
		
		Schema::create('mediables', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
			
			$table->unsignedInteger('media_id');
            $table->unsignedInteger('mediable_id');
            $table->unsignedInteger('order');

            $table->string('mediable_type');
            $table->string('tag');
            
            $table->primary(['media_id', 'mediable_type', 'mediable_id', 'tag']);
            $table->index(['mediable_id', 'mediable_type']);
            $table->index('tag');
            $table->index('order');
		});
		
		Schema::table('mediables', function (Blueprint $table) {
			$table->foreign('media_id')->references('id')->on('assets')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('mediables');
	}
}
