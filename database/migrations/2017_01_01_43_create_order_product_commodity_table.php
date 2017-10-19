<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductCommodityTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();
		 
		Schema::create('order_product_commodity', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
			
			$table->unsignedInteger('order_id')->nullable()->index()->comment('Foreign key to the orders table');
			
			$table->unsignedBigInteger('product_commodity_id')->nullable()->index()->comment('Foreign key to the product commodities table');
			
			$table->unsignedInteger('quantity')->nullable();
			$table->unsignedInteger('tax_rate')->nullable();
			
			$table->float('price', 8, 2);
			$table->float('price_tax', 8, 2);
		});
		
		Schema::table('order_product_commodity', function (Blueprint $table) {
			$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
			$table->foreign('product_commodity_id')->references('id')->on('product_commodities')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('order_product_commodity');
	}
}
