<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AssetsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');

		$assets = [];
		
		DB::table('assets')->delete();
		
		// DB::table('assets')->insert($assets);
	}
}
