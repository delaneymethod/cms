<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCharacteristicsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();
		
		Schema::create('product_characteristics', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
			
			$table->unsignedInteger('id')->primary();
			
			$table->unsignedInteger('product_attribute_id')->nullable()->index()->comment('Foreign key to the product attributes table');
	
			$table->string('value')->index();
			$table->string('commodity_code_representation')->index();
    		
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});
		
		Schema::table('product_characteristics', function (Blueprint $table) {
			$table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_characteristics');
	}
}
