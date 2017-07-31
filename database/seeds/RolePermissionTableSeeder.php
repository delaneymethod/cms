<?php
	
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('role_permission')->delete();
		
		$permissions = Permission::all();
		
		$permissions->each(function($permission) {
			$rolePermission = array(
				'role_id' => 1,
				'permission_id' => $permission->id
			);
			
			DB::table('role_permission')->insert($rolePermission);
		});
	}
}
