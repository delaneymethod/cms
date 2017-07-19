<?php
	
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionUserTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('permission_user')->delete();
		
		$permissions = Permission::all();
		
		$permissions->each(function($permission) {
			$permissionUser = array(
				'permission_id' => $permission->id,
				'user_id' => 1
			);
			
			DB::table('permission_user')->insert($permissionUser);
		});
	}
}
