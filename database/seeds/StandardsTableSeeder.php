<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StandardsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('standards')->delete();
		
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$standards = json_decode(file_get_contents('database/data/standards.json'), true);
		
		foreach ($standards as $standard) {
			DB::table('standards')->insert([
				'id' => $standard['Id'],
				'title' => $standard['Name'],
				'code' => $standard['Code'],
				'further_details' => $standard['FurtherDetails'],
				'standard_organisation_id' => $standard['StandardsOrganisationId'],
				'created_at' => $now,
				'updated_at' => $now,
			]);
		}
	}
}
