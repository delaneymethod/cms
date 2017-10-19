<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Illuminate\Database\Seeder;
use App\Http\Transformers\ProductTransformer;

class ProductAttributesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_attributes')->delete();
		
		$productAttributes = json_decode(file_get_contents('database/data/attributes.json'), true);
		
		$productAttributes = ProductTransformer::transformProductAttributes($productAttributes);
		
		collect($productAttributes)->each(function ($productAttribute) {
			DB::table('product_attributes')->insert($productAttribute);
		});
	}
}
