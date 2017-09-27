<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('product_categories', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

			$table->unsignedBigInteger('id')->primary();
			
			$table->string('title')->index();
			$table->string('slug')->index();
			
			$table->longText('description')->nullable();
			
			$table->unsignedBigInteger('parent_id')->nullable()->index();
			
			$table->unsignedInteger('sort_order')->nullable();
			$table->unsignedInteger('import_id')->nullable();
	
			$table->string('image_uri')->nullable();
			
			$table->boolean('publish_to_web')->nullable();
			
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});

		Schema::table('product_categories', function (Blueprint $table) {
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_categories');
	}
}
