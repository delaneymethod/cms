<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductManufacturersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('product_manufacturers', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

			$table->unsignedInteger('id')->primary();
			
			$table->string('title')->nullable()->index();
			$table->string('website')->nullable();
			$table->string('logo_image')->nullable();
			$table->string('cms_page_name')->nullable();
			
			$table->timestamps();
		});

		Schema::table('product_manufacturers', function (Blueprint $table) {
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_manufacturers');
	}
}
