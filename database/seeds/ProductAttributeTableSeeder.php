<?php

use Illuminate\Database\Seeder;
use App\Http\Transformers\ProductTransformer;

class ProductAttributeTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_attribute')->delete();
		
		$productAttributes = json_decode(file_get_contents('database/data/product_attributes.json'), true);
		
		$productAttributes = ProductTransformer::transformProductAttribute($productAttributes);
			
		collect($productAttributes)->each(function ($productAttribute) {
			DB::table('product_attribute')->insert($productAttribute);
		});
		
	}
}
