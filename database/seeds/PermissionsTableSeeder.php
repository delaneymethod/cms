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
			
			// Assets
			[
				'title' => 'view_assets',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'upload_assets',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_assets',
				'created_at' => $now,
				'updated_at' => $now,
			],
			
			// Statuses
			[
				'title' => 'view_statuses',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_statuses',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_statuses',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_statuses',
				'created_at' => $now,
				'updated_at' => $now,
			],
			
			// Roles
			[
				'title' => 'view_roles',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_roles',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_roles',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_roles',
				'created_at' => $now,
				'updated_at' => $now,
			],
			
			// Orders
			[
				'title' => 'view_orders',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_orders',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_orders',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_orders',
				'created_at' => $now,
				'updated_at' => $now,
			],
			
			// Articles
			[
				'title' => 'view_articles',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_articles',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_articles',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_articles',
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
			
			// Companies
			[
				'title' => 'view_companies',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_companies',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_companies',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_companies',
				'created_at' => $now,
				'updated_at' => $now,
			],
			
			// Locations
			[
				'title' => 'view_locations',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_locations',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_locations',
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_locations',
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('permissions')->delete();

		DB::table('permissions')->insert($permissions);
	}
}
