<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
			
		$articles = [
			[
				'title' => 'My First Blog Post',
				'slug' => 'my-first-blog-post',
				'keywords' => 'My,First,Blog,Post',
				'description' => 'My First Blog Post',
				'template_id' => 8,
				'user_id' => 1,
				'status_id' => 4,
				'published_at' => $now,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('articles')->delete();
		
		DB::table('articles')->insert($articles);
	}
}
