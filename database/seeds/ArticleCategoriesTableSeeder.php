<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ArticleCategoriesTableSeeder extends Seeder
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
				'title' => 'All Categories',
				'slug' => 'all-categories',
				'status_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Brands',
				'slug' => 'brands',
				'status_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Company News',
				'slug' => 'company-news',
				'status_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Technical',
				'slug' => 'technical',
				'status_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Products',
				'slug' => 'products',
				'status_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Tips / Guides',
				'slug' => 'tips-guides',
				'status_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'International',
				'slug' => 'international',
				'status_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];
			
		DB::table('article_categories')->delete();
		
		DB::table('article_categories')->insert($articleCategories);
	}
}
