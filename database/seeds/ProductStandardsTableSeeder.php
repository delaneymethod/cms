<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
		
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$standards = json_decode(file_get_contents('database/data/standards.json'), true);
		
		foreach ($standards as $standard) {
			DB::table('product_standards')->insert([
				'id' => $standard['Id'],
				'title' => $standard['Name'],
				'code' => $standard['Code'],
				'further_details' => $standard['FurtherDetails'],
				'product_standard_organisation_id' => $standard['StandardsOrganisationId'],
				'created_at' => $now,
				'updated_at' => $now,
			]);
		}
	}
}
