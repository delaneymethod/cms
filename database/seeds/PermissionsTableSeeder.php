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
				'group_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_users',
				'group_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_users',
				'group_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_passwords_users',
				'group_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'retire_users',
				'group_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_users',
				'group_id' => 1,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_permissions',
				'group_id' => 2,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_permissions',
				'group_id' => 2,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_permissions',
				'group_id' => 2,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_permissions',
				'group_id' => 2,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_assets',
				'group_id' => 3,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'upload_assets',
				'group_id' => 3,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_assets',
				'group_id' => 3,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'move_assets',
				'group_id' => 3,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_assets',
				'group_id' => 3,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_statuses',
				'group_id' => 4,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_statuses',
				'group_id' => 4,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_statuses',
				'group_id' => 4,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_statuses',
				'group_id' => 4,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_roles',
				'group_id' => 5,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_roles',
				'group_id' => 5,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_roles',
				'group_id' => 5,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_roles',
				'group_id' => 5,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_orders',
				'group_id' => 6,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_orders',
				'group_id' => 6,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_orders',
				'group_id' => 6,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_articles',
				'group_id' => 7,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_articles',
				'group_id' => 7,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_articles',
				'group_id' => 7,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_articles',
				'group_id' => 7,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_pages',
				'group_id' => 8,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_pages',
				'group_id' => 8,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_pages',
				'group_id' => 8,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_pages',
				'group_id' => 8,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_companies',
				'group_id' => 9,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_companies',
				'group_id' => 9,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_companies',
				'group_id' => 9,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_companies',
				'group_id' => 9,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_locations',
				'group_id' => 10,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_locations',
				'group_id' => 10,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_locations',
				'group_id' => 10,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'retire_locations',
				'group_id' => 10,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_locations',
				'group_id' => 10,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'suspend_locations',
				'group_id' => 10,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_article_categories',
				'group_id' => 11,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_article_categories',
				'group_id' => 11,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_article_categories',
				'group_id' => 11,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_article_categories',
				'group_id' => 11,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_templates',
				'group_id' => 12,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_templates',
				'group_id' => 12,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_templates',
				'group_id' => 12,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_templates',
				'group_id' => 12,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_products',
				'group_id' => 13,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'create_products',
				'group_id' => 13,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'edit_products',
				'group_id' => 13,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'delete_products',
				'group_id' => 13,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'title' => 'view_carts',
				'group_id' => 14,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];
				
		DB::table('permissions')->delete();
				
		DB::table('permissions')->insert($permissions);
	}
}
