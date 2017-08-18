<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();
		
		Schema::create('pages', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
			
			$table->increments('id');
			
			$table->string('title')->index();
			$table->string('slug');
			
			$table->mediumText('keywords')->nullable();
			
			$table->longText('description')->nullable();
			
			$table->unsignedInteger('template_id')->nullable()->index()->comment('Foreign key to the templates table');
			$table->unsignedInteger('status_id')->nullable()->index()->comment('Foreign key to the statuses table');
			$table->unsignedInteger('parent_id')->nullable()->index();
			$table->unsignedInteger('lft')->nullable()->index();
			$table->unsignedInteger('rgt')->nullable()->index();
			$table->unsignedInteger('depth')->nullable();
			$table->unsignedInteger('hide_from_nav')->nullable();
			
			$table->timestamps();
		});
		
		Schema::table('pages', function (Blueprint $table) {
			$table->foreign('template_id')->references('id')->on('templates')->onDelete('set null');
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
		Schema::dropIfExists('pages');
	}
}
