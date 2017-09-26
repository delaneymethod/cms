<?php

use Illuminate\Database\Seeder;
use App\Http\Transformers\ProductTransformer;

class ProductCategoriesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_categories')->delete();
		
		$productCategories = json_decode(file_get_contents('database/data/categories.json'), true);
		
		$productCategories = ProductTransformer::transformProductCategories($productCategories);
		
		collect($productCategories)->each(function ($productCategory) {
			DB::table('product_categories')->insert($productCategory);
		});
	}
}
