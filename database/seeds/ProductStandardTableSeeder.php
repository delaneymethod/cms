<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Illuminate\Database\Seeder;
use App\Http\Transformers\ProductTransformer;

class ProductStandardTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_standard')->delete();
		
		$productStandards = json_decode(file_get_contents('database/data/product_standards.json'), true);
		
		$productStandards = ProductTransformer::transformProductStandard($productStandards);
		
		collect($productStandards)->each(function ($productStandard) {
			DB::table('product_standard')->insert($productStandard);
		});
	}
}
