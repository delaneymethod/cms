<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderProductCommodityTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$orderProductCommodities = [];
		
		DB::table('order_product_commodity')->delete();
		
		//DB::table('order_product_commodity')->insert($orderProductCommodities);
	}
}
