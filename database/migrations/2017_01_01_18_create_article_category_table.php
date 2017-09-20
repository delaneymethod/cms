<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCategoryTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();
		 
		Schema::create('article_category', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
			
			$table->unsignedInteger('article_id')->comment('Foreign key to the articles table');
			$table->unsignedInteger('article_category_id')->comment('Foreign key to the article categories table');
		});
		
		Schema::table('article_category', function (Blueprint $table) {
			$table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
			$table->foreign('article_category_id')->references('id')->on('article_categories')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('article_category');
	}
}
