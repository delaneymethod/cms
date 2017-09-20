<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_categories')->delete();
		
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$categories = json_decode(file_get_contents('database/data/categories.json'), true);
		
		foreach ($categories as $category) {
			DB::table('product_categories')->insert([
				'id' => $category['Id'],
				'parent_id' => $category['ParentId'],
				'title' => $category['Name'],
				'description' => $category['Description'],
				'sort_order' => $category['SortOrder'],
				'import_id' => $category['ImportID'],
				'image_uri' => $category['ImageURI'],
				'publish_to_web' => $category['PublishToWeb'],
				'created_at' => $now,
				'updated_at' => $now,
			]);
		}
	}
}
