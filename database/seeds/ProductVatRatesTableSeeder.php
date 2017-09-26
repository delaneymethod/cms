<?php

use Illuminate\Database\Seeder;
use App\Http\Transformers\ProductTransformer;

class ProductVatRatesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_vat_rates')->delete();
		
		$productVatRates = json_decode(file_get_contents('database/data/vat_rates.json'), true);
		
		$productVatRates = ProductTransformer::transformProductVatRates($productVatRates);
		
		collect($productVatRates)->each(function ($productVatRate) {
			DB::table('product_vat_rates')->insert($productVatRate);
		});
	}
}
