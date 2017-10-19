<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CarouselsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$carousels = [
			[
				'title' => 'Homepage Carousel',
				'handle' => 'homepage_carousel',
				'data' => '',
				'created_at' => $now,
				'updated_at' => $now,
			],
		];
		
		DB::table('carousels')->delete();
		
		DB::table('carousels')->insert($carousels);
	}
}
