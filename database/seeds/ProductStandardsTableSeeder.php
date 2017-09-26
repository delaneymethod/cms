<?php

use Illuminate\Database\Seeder;
use App\Http\Transformers\ProductTransformer;

class ProductStandardsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_standards')->delete();
		
		$productStandards = json_decode(file_get_contents('database/data/standards.json'), true);
		
		$productStandards = ProductTransformer::transformProductStandards($productStandards);
		
		collect($productStandards)->each(function ($productStandard) {
			DB::table('product_standards')->insert($productStandard);
		});
	}
}
