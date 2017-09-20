<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
		
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$vatRates = json_decode(file_get_contents('database/data/vat_rates.json'), true);
		
		foreach ($vatRates as $vatRate) {
			DB::table('product_vat_rates')->insert([
				'id' => $vatRate['Id'],
				'code' => $vatRate['Code'],
				'description' => $vatRate['Description'],
				'rate' => $vatRate['Rate'],
				'rate_display' => $vatRate['RateDisplay'],
    			'created_at' => $now,
				'updated_at' => $now,
			]);
		}
	}
}
