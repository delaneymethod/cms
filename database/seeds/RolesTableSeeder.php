<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');

		$roles = [
			[
				'title' => 'Super Admin',
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('roles')->delete();

		DB::table('roles')->insert($roles);
	}
}
