<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVatRatesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('product_vat_rates', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

			$table->unsignedInteger('id')->primary();
			
			$table->string('code')->nullable()->index();
			$table->string('description')->nullable();
			
			$table->float('rate', 8, 2);
			
			$table->string('rate_display')->nullable();
			
			$table->timestamps();
		});

		Schema::table('product_vat_rates', function (Blueprint $table) {
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_vat_rates');
	}
}
