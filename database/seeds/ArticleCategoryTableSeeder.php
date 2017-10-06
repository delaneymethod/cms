<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ArticleCategoryTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$articleCategories = [
			[
				'article_id' => 1,
				'article_category_id' => 1,
			],
		];	
		
		DB::table('article_category')->delete();
		
		DB::table('article_category')->insert($articleCategories);
	}
}
