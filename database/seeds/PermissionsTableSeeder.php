<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$permissions = [
			
			// Permissions
			[
				'title' => 'view_permissions',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_permissions',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_permissions',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_permissions',
				'created_at' => $now,
				'updated_at' => $now,
			],
			
			// Users
			[
				'title' => 'view_users',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_users',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_users',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_passwords_users',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'retire_users',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_users',
				'created_at' => $now,
				'updated_at' => $now,
			],
			
			// Pages
			[
				'title' => 'view_pages',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_pages',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_pages',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_pages',
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('permissions')->delete();

		DB::table('permissions')->insert($permissions);
	}
}
