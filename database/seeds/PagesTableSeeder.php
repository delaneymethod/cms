<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$pages = [];
		
		DB::table('pages')->delete();
		
		// DB::table('pages')->insert($pages);
	}
}
