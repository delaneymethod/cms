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
		
		$permissions->each(function ($permission) {
			$rolePermission = [
				'role_id' => 1,
				'permission_id' => $permission->id,
			];
			
			DB::table('role_permission')->insert($rolePermission);
		});
	}
}
