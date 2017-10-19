<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStandardTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('product_standard', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

			$table->unsignedBigInteger('product_id')->nullable()->index()->comment('Foreign key to the products table');
			
			$table->unsignedInteger('product_standard_id')->nullable()->index()->comment('Foreign key to the product standards table');
		});

		Schema::table('product_standard', function (Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->foreign('product_standard_id')->references('id')->on('product_standards')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_standard');
	}
}
