<?php

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
			
			$table->unsignedInteger('standard_id')->nullable()->index()->comment('Foreign key to the standards table');
		});

		Schema::table('product_standard', function (Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->foreign('standard_id')->references('id')->on('standards')->onDelete('cascade');
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
