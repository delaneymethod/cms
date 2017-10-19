<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Illuminate\Database\Seeder;
use App\Http\Transformers\ProductTransformer;

class ProductsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('products')->delete();
		
		$products = json_decode(file_get_contents('database/data/products.json'), true);
		
		$products = ProductTransformer::transformProducts($products);
		
		collect($products)->each(function ($product) {
			DB::table('products')->insert($product);
		});
	}
}
