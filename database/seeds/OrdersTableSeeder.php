<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');

		$orders = [
			[
				'title' => 'Order 1',
				'user_id' => 1,
				'status_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('orders')->delete();

		DB::table('orders')->insert($orders);
	}
}
