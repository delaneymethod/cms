<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');

		$companies = [
			[
				'solution_id' => null,
				'title' => 'DelaneyMethod Web Development Ltd',
				'default_location_id' => 2,
				'created_at' => '2017-08-01 09:19:39',
				'updated_at' => '2017-08-02 13:03:22',
			],
			[	 
				'solution_id' => null,
				'title' => 'Grampian Fasteners',
				'default_location_id' => 1,
				'created_at' => '2017-08-01 12:01:53',
				'updated_at' => '2017-08-02 12:42:15',
			],
		];
		
		DB::table('companies')->delete();
		
		DB::table('companies')->insert($companies);
	}
}
