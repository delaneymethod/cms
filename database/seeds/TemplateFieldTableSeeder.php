<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

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
			
			// Homepage template fields
			[
				'template_id' => 1,
				'field_id' => 1,
				'order' => 1,
			],
			[
				'template_id' => 1,
				'field_id' => 2,
				'order' => 2,
			],
			[
				'template_id' => 1,
				'field_id' => 3,
				'order' => 3,
			],
			[
				'template_id' => 1,
				'field_id' => 4,
				'order' => 4,
			],
			
			// Page template fields
			[
				'template_id' => 2,
				'field_id' => 5,
				'order' => 1,
			],
			[
				'template_id' => 2,
				'field_id' => 6,
				'order' => 2,
			],
			[
				'template_id' => 2,
				'field_id' => 7,
				'order' => 3,
			],
			[
				'template_id' => 2,
				'field_id' => 8,
				'order' => 4,
			],
			[
				'template_id' => 2,
				'field_id' => 9,
				'order' => 5,
			],
			[
				'template_id' => 2,
				'field_id' => 10,
				'order' => 6,
			],
			[
				'template_id' => 2,
				'field_id' => 11,
				'order' => 7,
			],
			[
				'template_id' => 2,
				'field_id' => 12,
				'order' => 8,
			],
			[
				'template_id' => 2,
				'field_id' => 13,
				'order' => 9,
			],
			[
				'template_id' => 2,
				'field_id' => 14,
				'order' => 10,
			],
			[
				'template_id' => 2,
				'field_id' => 15,
				'order' => 11,
			],
			[
				'template_id' => 2,
				'field_id' => 16,
				'order' => 12,
			],
			[
				'template_id' => 2,
				'field_id' => 17,
				'order' => 13,
			],
			[
				'template_id' => 2,
				'field_id' => 18,
				'order' => 14,
			],
			[
				'template_id' => 2,
				'field_id' => 19,
				'order' => 15,
			],
			[
				'template_id' => 2,
				'field_id' => 20,
				'order' => 16,
			],
			[
				'template_id' => 2,
				'field_id' => 21,
				'order' => 17,
			],
			[
				'template_id' => 2,
				'field_id' => 22,
				'order' => 18,
			],
			[
				'template_id' => 2,
				'field_id' => 23,
				'order' => 19,
			],
			[
				'template_id' => 2,
				'field_id' => 24,
				'order' => 20,
			],
			[
				'template_id' => 2,
				'field_id' => 25,
				'order' => 21,
			],
			[
				'template_id' => 2,
				'field_id' => 26,
				'order' => 22,
			],
			
			// Contact template fields
			[
				'template_id' => 3,
				'field_id' => 27,
				'order' => 1,
			],
			[
				'template_id' => 3,
				'field_id' => 28,
				'order' => 2,
			],
			[
				'template_id' => 3,
				'field_id' => 29,
				'order' => 3,
			],
			
			// Products template fields
			[
				'template_id' => 4,
				'field_id' => 30,
				'order' => 1,
			],
			[
				'template_id' => 4,
				'field_id' => 31,
				'order' => 2,
			],
			[
				'template_id' => 4,
				'field_id' => 32,
				'order' => 3,
			],
			
			// Cart template fields
			[
				'template_id' => 5,
				'field_id' => 33,
				'order' => 1,
			],
			[
				'template_id' => 5,
				'field_id' => 34,
				'order' => 2,
			],
			[
				'template_id' => 5,
				'field_id' => 35,
				'order' => 3,
			],
			
			// Checkout template fields
			[
				'template_id' => 6,
				'field_id' => 36,
				'order' => 1,
			],
			[
				'template_id' => 6,
				'field_id' => 37,
				'order' => 2,
			],
			[
				'template_id' => 6,
				'field_id' => 38,
				'order' => 3,
			],
			
			// Articles template fields
			[
				'template_id' => 7,
				'field_id' => 39,
				'order' => 1,
			],
			[
				'template_id' => 7,
				'field_id' => 40,
				'order' => 2,
			],
			[
				'template_id' => 7,
				'field_id' => 41,
				'order' => 3,
			],
			
			// Article template fields
			[
				'template_id' => 8,
				'field_id' => 42,
				'order' => 1,
			],
			[
				'template_id' => 8,
				'field_id' => 43,
				'order' => 2,
			],
			[
				'template_id' => 8,
				'field_id' => 44,
				'order' => 3,
			],
			[
				'template_id' => 8,
				'field_id' => 45,
				'order' => 4,
			],
			[
				'template_id' => 8,
				'field_id' => 46,
				'order' => 5,
			],
			
			// Manufacturers template fields
			[
				'template_id' => 11,
				'field_id' => 47,
				'order' => 1,
			],
			[
				'template_id' => 11,
				'field_id' => 48,
				'order' => 2,
			],
			[
				'template_id' => 11,
				'field_id' => 49,
				'order' => 3,
			],
		
		];
		
		DB::table('template_field')->delete();
		
		DB::table('template_field')->insert($templateFields);
	}
}
