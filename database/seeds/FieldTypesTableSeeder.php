<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FieldTypesTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$fieldTypes = [
			[	
				'title' => 'Text',
				'type' => 'text',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[	
				'title' => 'Text - Multiline',
				'type' => 'textarea',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[	
				'title' => 'Text - Rich',
				'type' => 'textarea',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[	
				'title' => 'Number',
				'type' => 'number',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[	
				'title' => 'Password',
				'type' => 'password',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[	
				'title' => 'Select',
				'type' => 'select',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[	
				'title' => 'Select - Multi',
				'type' => 'select',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[	
				'title' => 'Radio',
				'type' => 'radio',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[	
				'title' => 'Checkbox',
				'type' => 'checkbox',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[	
				'title' => 'File',
				'type' => 'file',
				'created_at' => $now,
				'updated_at' => $now,
			],
		];
		
		DB::table('field_types')->delete();
		
		DB::table('field_types')->insert($fieldTypes);
	}
}
