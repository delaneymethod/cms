<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$permissions = [
			[
				'title' => 'view_users',
				'permission_group_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_users',
				'permission_group_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_users',
				'permission_group_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_passwords_users',
				'permission_group_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_settings_users',
				'permission_group_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'retire_users',
				'permission_group_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_users',
				'permission_group_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_permissions',
				'permission_group_id' => 2,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_permissions',
				'permission_group_id' => 2,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_permissions',
				'permission_group_id' => 2,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_permissions',
				'permission_group_id' => 2,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_assets',
				'permission_group_id' => 3,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'upload_assets',
				'permission_group_id' => 3,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_assets',
				'permission_group_id' => 3,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'move_assets',
				'permission_group_id' => 3,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_assets',
				'permission_group_id' => 3,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_statuses',
				'permission_group_id' => 4,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_statuses',
				'permission_group_id' => 4,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_statuses',
				'permission_group_id' => 4,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_statuses',
				'permission_group_id' => 4,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_roles',
				'permission_group_id' => 5,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_roles',
				'permission_group_id' => 5,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_roles',
				'permission_group_id' => 5,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_roles',
				'permission_group_id' => 5,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_orders',
				'permission_group_id' => 6,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_orders',
				'permission_group_id' => 6,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_articles',
				'permission_group_id' => 7,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_articles',
				'permission_group_id' => 7,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_articles',
				'permission_group_id' => 7,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_articles',
				'permission_group_id' => 7,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_pages',
				'permission_group_id' => 8,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_pages',
				'permission_group_id' => 8,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_pages',
				'permission_group_id' => 8,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_pages',
				'permission_group_id' => 8,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_companies',
				'permission_group_id' => 9,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_companies',
				'permission_group_id' => 9,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_companies',
				'permission_group_id' => 9,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_companies',
				'permission_group_id' => 9,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_locations',
				'permission_group_id' => 10,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_locations',
				'permission_group_id' => 10,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_locations',
				'permission_group_id' => 10,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'retire_locations',
				'permission_group_id' => 10,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_locations',
				'permission_group_id' => 10,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'suspend_locations',
				'permission_group_id' => 10,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_article_categories',
				'permission_group_id' => 11,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_article_categories',
				'permission_group_id' => 11,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_article_categories',
				'permission_group_id' => 11,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_article_categories',
				'permission_group_id' => 11,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_templates',
				'permission_group_id' => 12,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_templates',
				'permission_group_id' => 12,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_templates',
				'permission_group_id' => 12,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_templates',
				'permission_group_id' => 12,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_products',
				'permission_group_id' => 13,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_products',
				'permission_group_id' => 13,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_products',
				'permission_group_id' => 13,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_products',
				'permission_group_id' => 13,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_carts',
				'permission_group_id' => 14,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_globals',
				'permission_group_id' => 15,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_globals',
				'permission_group_id' => 15,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_globals',
				'permission_group_id' => 15,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_globals',
				'permission_group_id' => 15,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_carousels',
				'permission_group_id' => 16,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_carousels',
				'permission_group_id' => 16,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_carousels',
				'permission_group_id' => 16,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_carousels',
				'permission_group_id' => 16,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];
				
		DB::table('permissions')->delete();
				
		DB::table('permissions')->insert($permissions);
	}
}
