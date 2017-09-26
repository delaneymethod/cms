<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributeTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('product_attribute', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

			$table->unsignedBigInteger('product_id')->nullable()->index()->comment('Foreign key to the products table');
			
			$table->unsignedInteger('product_attribute_id')->nullable()->index()->comment('Foreign key to the product attributes table');
			$table->unsignedInteger('product_characteristic_id')->nullable()->index()->comment('Foreign key to the product characteristics table');
			$table->unsignedInteger('display_position')->nullable();
		});

		Schema::table('product_attribute', function (Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('cascade');
			$table->foreign('product_characteristic_id')->references('id')->on('product_characteristics')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_attribute');
	}
}
