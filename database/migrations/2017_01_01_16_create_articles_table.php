<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('articles', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
			
			$table->increments('id');
			
			$table->string('title')->index();
			$table->string('slug')->index();
			
			$table->mediumText('keywords')->nullable();
			
			$table->longText('description')->nullable();
			
			$table->unsignedInteger('template_id')->nullable()->index()->comment('Foreign key to the templates table');
			$table->unsignedInteger('user_id')->nullable()->index()->comment('Foreign key to the users table');
			$table->unsignedInteger('status_id')->nullable()->index()->comment('Foreign key to the statuses table');
			
			$table->timestamp('published_at');
			
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});

		Schema::table('articles', function (Blueprint $table) {
			$table->foreign('template_id')->references('id')->on('templates')->onDelete('set null');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
		Schema::dropIfExists('articles');
	}
}
