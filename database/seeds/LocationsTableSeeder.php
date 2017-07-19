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
				'title' => 'Westhill, Aberdeen',
				'status_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('locations')->delete();

		DB::table('locations')->insert($locations);
	}
}
