<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();
		 
		Schema::create('order_product', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
			
			$table->unsignedInteger('order_id')->comment('Foreign key to the orders table');
			$table->unsignedInteger('product_id')->comment('Foreign key to the products table');
			$table->unsignedInteger('quantity');
			$table->unsignedInteger('tax_rate');
			
			$table->float('price', 8, 2);
			$table->float('price_tax', 8, 2);
		});
		
		Schema::table('order_product', function (Blueprint $table) {
			$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('order_product');
	}
}
