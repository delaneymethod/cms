<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContentsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');

		$contents = [
			[
				'field_id' => 1,
				'data' => '<p>This is the Homepage.</p>',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'field_id' => 2,
				'data' => '<p>This is the About page.</p>',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'field_id' => 2,
				'data' => '<p>This is Sean\'s test page.</p>',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'field_id' => 10,
				'data' => 'This is an example excerpt field.',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'field_id' => 9,
				'data' => '<p>This<em> is</em> an <del>example</del> <strong>content</strong> field.</p>',
				'created_at' => $now,
				'updated_at' => $now,
			],
		];
		
		DB::table('contents')->delete();
		
		DB::table('contents')->insert($contents);
	}
}
