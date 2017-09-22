<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FieldsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$fields = [
			[	
				'title' => 'Content',
				'handle' => 'content',
				'instructions' => NULL,
				'options' => NULL,
				'field_type_id' => 3,
				'required' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Content',
				'handle' => 'content',
				'instructions' => NULL,
				'options' => NULL,
				'field_type_id' => 3,
				'required' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Content',
				'handle' => 'content',
				'instructions' => NULL,
				'options' => NULL,
				'field_type_id' => 3,
				'required' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Content',
				'handle' => 'content',
				'instructions' => NULL,
				'options' => NULL,
				'field_type_id' => 3,
				'required' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Content',
				'handle' => 'content',
				'instructions' => NULL,
				'options' => NULL,
				'field_type_id' => 3,
				'required' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Content',
				'handle' => 'content',
				'instructions' => NULL,
				'options' => NULL,
				'field_type_id' => 3,
				'required' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Content',
				'handle' => 'content',
				'instructions' => NULL,
				'options' => NULL,
				'field_type_id' => 3,
				'required' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Content',
				'handle' => 'content',
				'instructions' => NULL,
				'options' => NULL,
				'field_type_id' => 3,
				'required' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Content',
				'handle' => 'content',
				'instructions' => NULL,
				'options' => NULL,
				'field_type_id' => 3,
				'required' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Excerpt',
				'handle' => 'excerpt',
				'instructions' => NULL,
				'options' => NULL,
				'field_type_id' => 2,
				'required' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Content',
				'handle' => 'content',
				'instructions' => NULL,
				'options' => NULL,
				'field_type_id' => 3,
				'required' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'Content',
				'handle' => 'content',
				'instructions' => NULL,
				'options' => NULL,
				'field_type_id' => 3,
				'required' => 0,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];
		
		DB::table('fields')->delete();
		
		DB::table('fields')->insert($fields);
	}
}
