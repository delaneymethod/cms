<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Http\Traits\PermissionTrait;

class RolePermissionTableSeeder extends Seeder
{
	use PermissionTrait;
	
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('role_permission')->delete();
		
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$permissions = $this->getPermissions();
		
		// Super Admin Permissions
		$permissions->each(function ($permission) {
			$rolePermission = [
				'role_id' => 1,
				'permission_id' => $permission->id,
			];
			
			DB::table('role_permission')->insert($rolePermission);
		});
		
		$permissionIds = collect([1, 2, 3, 4, 5, 6, 24, 25, 38, 39, 40, 41, 42, 43, 56]);
		
		// Admin Permissions
		$permissionIds->each(function ($permissionId) {
			$rolePermission = [
				'role_id' => 2,
				'permission_id' => $permissionId,
			];
			
			DB::table('role_permission')->insert($rolePermission);
		});
		
		$permissionIds = collect([1, 3, 24, 25, 56]);
		
		// User Permissions
		$permissionIds->each(function ($permissionId) {
			$rolePermission = [
				'role_id' => 3,
				'permission_id' => $permissionId,
			];
			
			DB::table('role_permission')->insert($rolePermission);
		});
	}
}
