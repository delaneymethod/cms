<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductCharacteristicsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_characteristics')->delete();
		
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$characteristics = json_decode(file_get_contents('database/data/characteristics.json'), true);
		
		foreach ($characteristics as $characteristic) {
			DB::table('product_characteristics')->insert([
				'id' => $characteristic['Id'],
				'product_attribute_id' => $characteristic['AttributeId'],
				'value' => $characteristic['Value'],
				'commodity_code_representation' => $characteristic['CommodityCodeRepresentation'],
				'created_at' => $now,
				'updated_at' => $now,
			]);
		}
	}
}
