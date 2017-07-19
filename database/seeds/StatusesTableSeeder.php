<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');

		$statuses = [
			[
				'title' => 'Active',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Pending',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Retired',
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('statuses')->delete();

		DB::table('statuses')->insert($statuses);
	}
}
