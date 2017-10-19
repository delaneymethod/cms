<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Illuminate\Database\Seeder;
use App\Http\Transformers\ProductTransformer;

class ProductCommoditiesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_commodities')->delete();
		
		$productCommodities = json_decode(file_get_contents('database/data/commodities.json'), true);
		
		$productCommodities = ProductTransformer::transformProductCommodities($productCommodities);
		
		collect($productCommodities)->each(function ($productCommodity) {
			DB::table('product_commodities')->insert($productCommodity);
		});
	}
}
