<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductCommoditiesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_commodities')->delete();
		
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$commodities = json_decode(file_get_contents('database/data/commodities.json'), true);
		
		foreach ($commodities as $commodity) {
			DB::table('product_commodities')->insert([
				'id' => $commodity['Id'],
				'title' => $commodity['Name'],
				'is_dirty' => $commodity['IsDirty'],
				'weight' => $commodity['Weight'],
				'weight_per' => $commodity['WeightPer'],
				'internal_part_number' => $commodity['InternalPartNumber'],
				'timecheck' => $commodity['Timecheck'],
				'code' => $commodity['Code'],
				'created_user_id' => $commodity['CreatedUserId'],
				'created_time' => $commodity['CreatedTime'],
				'approval_employee_id' => $commodity['ApprovalEmployeeId'],
				'approval_date' => $commodity['ApprovalDate'],
				'retire_date' => $commodity['RetireDate'],
				'retire_employee_id' => $commodity['RetireEmployeeId'],
				'short_description' => $commodity['ShortDescription'],
				'product_id' => $commodity['ProductId'],
				'legacy_matched' => $commodity['LegacyMatched'],
				'quantity_available' => $commodity['QuantityAvailable'],
				'price_band_id' => $commodity['PriceBandId'],
				'pack_quantity' => $commodity['PackQuantity'],
				'country_of_origin_id' => $commodity['CountryOfOriginID'],
				'created_at' => $now,
				'updated_at' => $now,
			]);
		}
	}
}
