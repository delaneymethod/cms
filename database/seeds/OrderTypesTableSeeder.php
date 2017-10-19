<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderTypesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		 
		$orderTypes = [
			[	
				'title' => 'Web',
				'slug' => 'web',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Shop',
				'slug' => 'shop',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Email',
				'slug' => 'email',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Telephone',
				'slug' => 'telephone',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Fax',
				'slug' => 'fax',
				'created_at' => $now,
				'updated_at' => $now,
			],
		];
		
		DB::table('order_types')->delete();

		DB::table('order_types')->insert($orderTypes);
	}
}
