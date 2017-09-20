<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StandardOrganisationsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('standard_organisations')->delete();
		
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$standardOrganisations = json_decode(file_get_contents('database/data/standards_organisations.json'), true);
		
		foreach ($standardOrganisations as $standardOrganisation) {
			DB::table('standard_organisations')->insert([
				'id' => $standardOrganisation['Id'],
				'title' => $standardOrganisation['Name'],
				'website' => $standardOrganisation['Website'],
				'description' => $standardOrganisation['Description'],
				'timecheck' => $standardOrganisation['Timecheck'],
				'created_at' => $now,
				'updated_at' => $now,
			]);
		}
	}
}
