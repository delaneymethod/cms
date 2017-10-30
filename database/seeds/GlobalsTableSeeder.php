<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GlobalsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$globals = [
			[
				'title' => 'Site Name',
				'handle' => 'site_name',
				'data' => 'Test Site',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Site Logo',
				'handle' => 'site_logo',
				'data' => '/assets/img/logo.png',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'LinkedIn',
				'handle' => 'linkedin',
				'data' => 'https://www.linkedin.com/company/grampian-fasteners',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Twitter',
				'handle' => 'twitter',
				'data' => 'https://twitter.com/fastenerpeople',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Facebook',
				'handle' => 'facebook',
				'data' => 'https://www.facebook.com/GrampianFasteners92',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Google Analytics',
				'handle' => 'google_analytics',
				'data' => 'XX-XXX-XXX',
				'created_at' => $now,
				'updated_at' => $now,
			],
		];
		
		DB::table('globals')->delete();
		
		DB::table('globals')->insert($globals);
	}
}
