<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CartsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$carts = [];
			 
		DB::table('carts')->delete();
		
		//DB::table('carts')->insert($carts);
	}
}
