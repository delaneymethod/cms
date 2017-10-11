<?php
	
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$users = [
			[
				'solution_id' => null,
				'first_name' => 'Sean',
				'last_name' => 'Delaney',
				'slug' => 'sean-delaney',
				'email' => 'hello@delaneymethod.com',
				'password' => bcrypt('12345678'),
				'job_title' => 'Software Engineer',
				'telephone' => '+44 1224 123 456',
				'mobile' => '+447789571206',
				'company_id' => 1,
				'location_id' => 2,
				'status_id' => 1,
				'role_id' => 1,
				'remember_token' => NULL,
				'last_login_at' => NULL,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'solution_id' => null,
				'first_name' => 'Zara',
				'last_name' => 'Vaughan',
				'slug' => 'zara-vaughan',
				'email' => 'zara.vaughan@grampianfasteners.com',
				'password' => bcrypt('12345678'),
				'job_title' => 'Digital Media Marketing Manager',
				'telephone' => '+44 1224 123 456',
				'mobile' => '+44 700 123 4567',
				'company_id' => 2,
				'location_id' => 1,
				'status_id' => 1,
				'role_id' => 2,
				'remember_token' => NULL,
				'last_login_at' => NULL,
				'created_at' => '2017-08-01 11:56:34',
				'updated_at' => '2017-09-06 14:34:00',
			],
			[ 
				'solution_id' => null,
				'first_name' => 'Test',
				'last_name' => 'User 1',
				'slug' => 'test-user-1',
				'email' => 'tu1@domain.tld',
				'password' => bcrypt('12345678'),
				'job_title' => 'Business Development Manager',
				'telephone' => '+44 1224 123 456',
				'mobile' => '+44 777 123 456',
				'company_id' => 1,
				'location_id' => 4,
				'status_id' => 1,
				'role_id' => 3,
				'remember_token' => NULL,
				'last_login_at' => NULL,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'solution_id' => null,
				'first_name' => 'Test',
				'last_name' => 'User 2',
				'slug' => 'test-user-2',
				'email' => 'tu2@domain.tld',
				'password' => bcrypt('12345678'),
				'job_title' => '',
				'telephone' => '+44 1224 123 456',
				'mobile' => '+44 777 123 456',
				'company_id' => 1,
				'location_id' => 4,
				'status_id' => 1,
				'role_id' => 3,
				'remember_token' => NULL,
				'last_login_at' => NULL,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'solution_id' => null,
				'first_name' => 'Test',
				'last_name' => 'User 3',
				'slug' => 'test-user-3',
				'email' => 'tu3@domain.tld',
				'password' => bcrypt('12345678'),
				'job_title' => '',
				'telephone' => '+44 1224 123 456',
				'mobile' => '+44 777 123 456',
				'company_id' => 2,
				'location_id' => 4,
				'status_id' => 1,
				'role_id' => 3,
				'remember_token' => NULL,
				'last_login_at' => NULL,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'solution_id' => null,
				'first_name' => 'Test',
				'last_name' => 'User 4',
				'slug' => 'test-user-4',
				'email' => 'tu4@domain.tld',
				'password' => bcrypt('12345678'),
				'job_title' => '',
				'telephone' => '+44 1224 123 456',
				'mobile' => '+44 777 123 456',
				'company_id' => 2,
				'location_id' => 4,
				'status_id' => 1,
				'role_id' => 3,
				'remember_token' => NULL,
				'last_login_at' => NULL,
				'created_at' => $now,
				'updated_at' => $now,
			],
			[
				'solution_id' => null,
				'first_name' => 'Test',
				'last_name' => 'User 5',
				'slug' => 'test-user-5',
				'email' => 'tu5@domain.tld',
				'password' => bcrypt('12345678'),
				'job_title' => '',
				'telephone' => '+44 1224 123 456',
				'mobile' => '+44 777 123 456',
				'company_id' => 2,
				'location_id' => 4,
				'status_id' => 1,
				'role_id' => 3,
				'remember_token' => NULL,
				'last_login_at' => NULL,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];
			
		DB::table('users')->delete();
		
		DB::table('users')->insert($users);
	}
}
