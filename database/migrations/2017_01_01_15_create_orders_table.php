<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('orders', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
			
			$table->increments('id');
			
			$table->unsignedBigInteger('solution_id')->nullable();
			
			$table->string('order_number')->index();
			$table->string('po_number')->index();
			
			$table->longText('notes')->nullable();
			
			$table->unsignedInteger('order_type_id')->nullable()->index()->comment('Foreign key to the order types table');
			$table->unsignedInteger('shipping_method_id')->nullable()->index()->comment('Foreign key to the shipping methods table');
			$table->unsignedInteger('location_id')->nullable()->index()->comment('Foreign key to the locations table');
			$table->unsignedInteger('user_id')->nullable()->index()->comment('Foreign key to the users table');
			$table->unsignedInteger('status_id')->nullable()->index()->comment('Foreign key to the statuses table');
			$table->unsignedInteger('count');
			
			$table->float('tax', 8, 2);
			$table->float('subtotal', 8, 2);
			$table->float('total', 8, 2);
			
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});

		Schema::table('orders', function (Blueprint $table) {
			$table->foreign('order_type_id')->references('id')->on('order_types')->onDelete('set null');
			$table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->onDelete('set null');
			$table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
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
		Schema::dropIfExists('orders');
	}
}
