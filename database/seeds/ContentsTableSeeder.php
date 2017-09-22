<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContentsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');

		$contents = [];
		
		DB::table('contents')->delete();
		
		//DB::table('contents')->insert($contents);
	}
}
