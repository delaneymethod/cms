<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCommoditiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('product_commodities', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

			$table->unsignedBigInteger('id')->primary();
			
			$table->string('title')->index();
			
			$table->boolean('is_dirty')->nullable();
			
			$table->float('weight', 8, 2);
	
			$table->unsignedInteger('weight_per')->nullable();
			
			$table->string('internal_part_number')->nullable();
			$table->string('timecheck')->nullable();
			$table->string('code')->nullable();
			
			$table->unsignedInteger('created_user_id')->nullable();
			
			$table->string('created_time')->nullable();
			
			$table->unsignedInteger('approval_employee_id')->nullable();
			
			$table->string('approval_date')->nullable();
			$table->string('retire_date')->nullable();
			$table->string('retire_employee_id')->nullable();
			
			$table->longText('short_description')->nullable();
			
			$table->unsignedBigInteger('product_id')->nullable()->index()->comment('Foreign key to the products table');
			
			$table->boolean('legacy_matched')->nullable();
			
			$table->unsignedInteger('quantity_available')->nullable();
			$table->unsignedInteger('price_band_id')->nullable();
			$table->unsignedInteger('pack_quantity')->nullable();
			$table->unsignedInteger('country_of_origin_id')->nullable();
			
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});

		Schema::table('product_commodities', function (Blueprint $table) {
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
		Schema::dropIfExists('product_commodities');
	}
}
