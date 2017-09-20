<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$statuses = [
			[
				'title' => 'Active',
				'description' => NULL,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Pending',
				'description' => 'Users with this status cannot login.',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Retired',
				'description' => 'Users with this status cannot login.',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Published',
				'description' => NULL,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Private',
				'description' => 'Articles or Pages with this status will be hidden from any menu/navigation.',
				'created_at' => $now,				
				'updated_at' => $now,
			],
			[
				'title' => 'Draft',
				'description' => 'Articles or Pages with this status will be hidden from any menu/navigation.',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Suspended',
				'description' => 'Users or Locations with this status cannot checkout. However, Users can still login and access the dashboard.',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Delivered',
				'description' => '',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Shipped',
				'description' => '',
				'created_at' => $now,
				'updated_at' => $now,
			],
		];
		
		DB::table('statuses')->delete();
		
		DB::table('statuses')->insert($statuses);	
	}
}
