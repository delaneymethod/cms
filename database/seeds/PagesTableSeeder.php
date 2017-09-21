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
		
		$pages = [
			[
				'title' => 'Home',
				'slug' => '',
				'keywords' => NULL,
				'description' => NULL,
				'template_id' => 1,
				'status_id' => 4,
				'parent_id' => NULL,
				'lft' => 1,
				'rgt' => 2,
				'depth' => 0,
				'hide_from_nav' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'About Us',
				'slug' => 'about-us',
				'keywords' => '',
				'description' => NULL,
				'template_id' => 2,
				'status_id' => 4,
				'parent_id' => NULL,
				'lft' => 3,
				'rgt' => 6,
				'depth' => 0,
				'hide_from_nav' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Services',
				'slug' => 'services',
				'keywords' => NULL,
				'description' => NULL,
				'template_id' => 2,
				'status_id' => 4,
				'parent_id' => NULL,
				'lft' => 7,
				'rgt' => 8,
				'depth' => 0,
				'hide_from_nav' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Browse',
				'slug' => 'browse',
				'keywords' => '',
				'description' => NULL,
				'template_id' => 4,
				'status_id' => 4,
				'parent_id' => NULL,
				'lft' => 9,
				'rgt' => 10,
				'depth' => 0,
				'hide_from_nav' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Cart',
				'slug' => 'cart',
				'keywords' => '',
				'description' => NULL,
				'template_id' => 5,
				'status_id' => 4,
				'parent_id' => NULL,
				'lft' => 11,
				'rgt' => 16,
				'depth' => 0,
				'hide_from_nav' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Checkout',
				'slug' => 'checkout',
				'keywords' => '',
				'description' => NULL,
				'template_id' => 6,
				'status_id' => 4,
				'parent_id' => 5,
				'lft' => 12,
				'rgt' => 15,
				'depth' => 1,
				'hide_from_nav' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Confirmation',
				'slug' => 'confirmation',
				'keywords' => NULL,
				'description' => NULL,
				'template_id' => 2,
				'status_id' => 4,
				'parent_id' => 6,
				'lft' => 13,
				'rgt' => 14,
				'depth' => 2,
				'hide_from_nav' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Hidden from Nav',
				'slug' => 'hidden-from-nav',
				'keywords' => NULL,
				'description' => NULL,
				'template_id' => 2,
				'status_id' => 4,
				'parent_id' => NULL,
				'lft' => 17,
				'rgt' => 18,
				'depth' => 0,
				'hide_from_nav' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Articles',
				'slug' => 'articles',
				'keywords' => NULL,
				'description' => NULL,
				'template_id' => 7,
				'status_id' => 4,
				'parent_id' => NULL,
				'lft' => 19,
				'rgt' => 20,
				'depth' => 0,
				'hide_from_nav' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Sean&#39;s Test Page',
				'slug' => 'seans-test-page',
				'keywords' => 'Sean\'s,Test,Page',
				'description' => NULL,
				'template_id' => 2,
				'status_id' => 4,
				'parent_id' => 2,
				'lft' => 4,
				'rgt' => 5,
				'depth' => 1,
				'hide_from_nav' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];
		
		DB::table('pages')->delete();
		
		DB::table('pages')->insert($pages);
	}
}
