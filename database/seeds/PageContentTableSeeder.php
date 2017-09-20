<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PageContentTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');

		$pageContents = [
			[
				'page_id' => 1,
				'content_id' => 1,
			],
		];
		
		DB::table('page_content')->delete();
		
		DB::table('page_content')->insert($pageContents);
	}
}
