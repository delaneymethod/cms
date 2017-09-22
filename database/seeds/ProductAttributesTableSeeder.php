<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductAttributesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_attributes')->delete();
		
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$attributes = json_decode(file_get_contents('database/data/attributes.json'), true);
		
		foreach ($attributes as $attribute) {
			DB::table('product_attributes')->insert([
				'id' => $attribute['Id'],
				'title' => $attribute['Name'],
				'created_at' => $now,
				'updated_at' => $now,
			]);
		}
	}
}
