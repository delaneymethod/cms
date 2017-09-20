<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('products', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

			$table->unsignedBigInteger('id')->primary();
			
			$table->string('title')->nullable()->index();
			
			$table->unsignedInteger('sort_order')->nullable();
			
			$table->unsignedBigInteger('product_category_id')->nullable()->index()->comment('Foreign key to the product categories table');
			
			$table->unsignedInteger('product_manufacturer_id')->nullable()->index()->comment('Foreign key to the product manufacturers table');
			
			$table->unsignedInteger('harmonised_code_id')->nullable();
			$table->unsignedInteger('supplier_id')->nullable();
			
			$table->unsignedInteger('product_vat_rate_id')->nullable()->index()->comment('Foreign key to the product vat rates table');
			
			$table->boolean('limited_life')->nullable();
			$table->boolean('test_certificates_required')->nullable();
			
			$table->string('commodity_name_protocol')->nullable();
			$table->string('commodity_code_protocol')->nullable();
			$table->string('commodity_short_description_protocol')->nullable();
			
			$table->dateTime('retire_date')->nullable();
			
			$table->unsignedInteger('retire_employee_id')->nullable();
			
			$table->longText('description')->nullable();
			
			$table->string('short_name')->nullable()->index();
			$table->string('image_uri')->nullable();
			
			$table->timestamps();
		});

		Schema::table('products', function (Blueprint $table) {
			$table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('set null');
			$table->foreign('product_manufacturer_id')->references('id')->on('product_manufacturers')->onDelete('set null');
			$table->foreign('product_vat_rate_id')->references('id')->on('product_vat_rates')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('products');
	}
}
