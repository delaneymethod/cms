<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Illuminate\Database\Seeder;
use App\Http\Transformers\ProductTransformer;

class ProductManufacturersTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_manufacturers')->delete();
		
		$productManufacturers = json_decode(file_get_contents('database/data/manufacturers.json'), true);
		
		$productManufacturers = ProductTransformer::transformProductManufacturers($productManufacturers);
		
		collect($productManufacturers)->each(function ($productManufacturer) {
			DB::table('product_manufacturers')->insert($productManufacturer);
		});
	}
}
