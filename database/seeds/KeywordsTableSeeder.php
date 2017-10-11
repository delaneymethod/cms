<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class KeywordsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$keywords = [];
		
		DB::table('keywords')->delete();
		
		// DB::table('keywords')->insert($locations);
	}
}
