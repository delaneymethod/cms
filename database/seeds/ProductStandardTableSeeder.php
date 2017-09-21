<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
		
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$productStandards = json_decode(file_get_contents('database/data/product_standards.json'), true);
		
		foreach ($productStandards as $productStandard) {
			DB::table('product_standard')->insert([
				'product_id' => $productStandard['ProductId'],
				'product_standard_id' => $productStandard['StandardId'],
			]);
		}
	}
}
