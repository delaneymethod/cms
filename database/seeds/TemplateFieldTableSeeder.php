<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TemplateFieldTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$templateFields = [
			[
				'template_id' => 1,
				'field_id' => 1,
				'order' => 1,
			],
			[
				'template_id' => 2,
				'field_id' => 2,
				'order' => 1,
			],
			[
				'template_id' => 2,
				'field_id' => 14,
				'order' => 0,
			],
			[
				'template_id' => 2,
				'field_id' => 15,
				'order' => 2,
			],
			[
				'template_id' => 3,
				'field_id' => 3,
				'order' => 1,
			],
			[
				'template_id' => 4,
				'field_id' => 4,
				'order' => 1,
			],
			[
				'template_id' => 5,
				'field_id' => 5,
				'order' => 1,
			],
			[
				'template_id' => 6,
				'field_id' => 6,
				'order' => 1,
			],
			[
				'template_id' => 7,
				'field_id' => 7,
				'order' => 1,
			],
			[
				'template_id' => 8,
				'field_id' => 9,
				'order' => 2,
			],
			[
				'template_id' => 8,
				'field_id' => 10,
				'order' => 1,
			],
			[
				'template_id' => 9,
				'field_id' => 11,
				'order' => 1,
			],
			[
				'template_id' => 10,
				'field_id' => 12,
				'order' => 1,
			],
		];
		
		DB::table('template_field')->delete();
		
		DB::table('template_field')->insert($templateFields);
	}
}
