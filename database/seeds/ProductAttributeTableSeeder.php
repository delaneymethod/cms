<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
		
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$productAttributes = json_decode(file_get_contents('database/data/product_attributes.json'), true);
		
		foreach ($productAttributes as $productAttribute) {
			DB::table('product_attribute')->insert([
				'product_id' => $productAttribute['ProductId'],
				'product_attribute_id' => $productAttribute['AttributeId'],
				'fixed_characteristic_id' => $productAttribute['FixedCharacteristicId'],
				'display_position' => $productAttribute['DisplayPosition'],
			]);
		}
	}
}
