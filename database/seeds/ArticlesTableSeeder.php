<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
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
				'user_id' => 1,
				'status_id' => 1,
				'content' => '<p>My First Blog Post.</p>',
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('articles')->delete();

		DB::table('articles')->insert($articles);
	}
}
