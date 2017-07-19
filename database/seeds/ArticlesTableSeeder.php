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
				'title' => 'Blog Post 1',
				'user_id' => 1,
				'status_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('articles')->delete();

		DB::table('articles')->insert($articles);
	}
}
