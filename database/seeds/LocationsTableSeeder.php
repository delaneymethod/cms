<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');

		$locations = [
			[
				'title' => 'Dyce, Aberdeen',
				'unit' => '',
				'building' => 'Grampian House',
				'street_address_1' => 'Pitmedden Road',
				'street_address_2' => 'Dyce',
				'street_address_3' => '',
				'street_address_4' => '',
				'town_city' => 'Aberdeen',
				'postal_code' => 'AB21 0DP',
				'county_id' => 33,
				'country_id' => 3,
				'telephone' => '+44 1224 772 777',
				'company_id' => 1,
				'status_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('locations')->delete();

		DB::table('locations')->insert($locations);
	}
}
