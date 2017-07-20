<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AssetsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');

		$assets = [
			[
				'title' => 'Asset 1',
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('assets')->delete();

		DB::table('assets')->insert($assets);
	}
}
