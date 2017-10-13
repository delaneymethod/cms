<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TemplatesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$templates = [
			[
				'title' => 'Homepage',
				'filename' => 'homepage',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Page',
				'filename' => 'page',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Contact',
				'filename' => 'contact',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Products',
				'filename' => 'products',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Cart',
				'filename' => 'cart',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Checkout',
				'filename' => 'checkout',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Articles',
				'filename' => 'articles',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Article',
				'filename' => 'article',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Product',
				'filename' => 'product',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Product Category',
				'filename' => 'productCategory',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Manufacturers',
				'filename' => 'manufacturers',
				'created_at' => $now,
				'updated_at' => $now,
			],
			
		];
		
		DB::table('templates')->delete();
		
		DB::table('templates')->insert($templates);
	}
}
