<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarouselsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::enableForeignKeyConstraints();

		Schema::create('carousels', function (Blueprint $table) {
			$table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';

			$table->increments('id');
			
			$table->string('title')->index();
			$table->string('handle');
			
			$table->longText('data')->nullable();
			
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
		});

		Schema::table('carousels', function (Blueprint $table) {
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('carousels');
	}
}
