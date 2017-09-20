<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderProductTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$orderProducts = [];
		
		DB::table('order_product')->delete();
		
		//DB::table('order_product')->insert($orderProducts);
	}
}
