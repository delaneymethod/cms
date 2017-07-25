<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');

		$companies = [
			[
				'title' => 'DelaneyMethod Web Development Ltd',
				'default_location_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('companies')->delete();

		DB::table('companies')->insert($companies);
	}
}
