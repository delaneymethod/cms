<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$users = [
			[
				'first_name' => 'Sean',
				'last_name' => 'Delaney',
				'email' => 'hello@delaneymethod.com',
				'password' => bcrypt('12345678'),
				'job_title' => '',
				'telephone' => '',
				'mobile' => '',
				'location_id' => 1,
				'status_id' => 1,
				'role_id' => 1,
				'last_login_at' => $now,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('users')->delete();

		DB::table('users')->insert($users);
	}
}
