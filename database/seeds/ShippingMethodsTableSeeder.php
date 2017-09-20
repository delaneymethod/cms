<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ShippingMethodsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$shippingMethods = [
			[
				'title' => 'Grampian Fasteners',
				'free_threshold' => 0.00,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Collection',
				'free_threshold' => 0.00,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Mac&#39;s Express',
				'free_threshold' => 100.00,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'APC Overnight',
				'free_threshold' => 100.00,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'DPD',
				'free_threshold' => 100.00,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('shipping_methods')->delete();

		DB::table('shipping_methods')->insert($shippingMethods);
	}
}
