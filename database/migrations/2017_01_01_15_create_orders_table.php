<?php

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
			
			$table->string('order_number')->index();
			$table->string('po_number')->index();
			
			$table->longText('notes')->nullable();
			
			$table->unsignedInteger('order_type_id')->nullable()->index()->comment('Foreign key to the order types table');
			$table->unsignedInteger('delivery_method_id')->nullable()->index()->comment('Foreign key to the delivery methods table');
			$table->unsignedInteger('location_id')->nullable()->index()->comment('Foreign key to the locations table');
			$table->unsignedInteger('user_id')->nullable()->index()->comment('Foreign key to the users table');
			$table->unsignedInteger('status_id')->nullable()->index()->comment('Foreign key to the statuses table');
			$table->unsignedInteger('count');
			
			$table->float('tax', 8, 2);
			$table->float('subtotal', 8, 2);
			$table->float('total', 8, 2);
			
			$table->timestamps();
		});

		Schema::table('orders', function (Blueprint $table) {
			$table->foreign('order_type_id')->references('id')->on('order_types')->onDelete('set null');
			$table->foreign('delivery_method_id')->references('id')->on('delivery_methods')->onDelete('set null');
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
