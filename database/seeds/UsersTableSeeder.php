<?php

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
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'first_name' => 'Sean',
                'last_name' => 'Delaney',
                'email' => 'hello@delaneymethod.com',
                'password' => '$2y$10$6ZfVjX7VvPlexW0vZrhVMOrq3ZHXKQmS4b8QurMU7A69WyxuYASra',
                'job_title' => 'Software Engineer',
                'telephone' => '+44 1224 123 456',
                'mobile' => '+447789571206',
                'company_id' => 1,
                'location_id' => 2,
                'status_id' => 1,
                'role_id' => 1,
                'remember_token' => NULL,
                'last_login_at' => '2017-08-01 09:19:39',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 12:01:38',
            ),
            1 => 
            array (
                'id' => 2,
                'first_name' => 'Zara',
                'last_name' => 'Vaughan',
                'email' => 'zara.vaughan@grampianfasteners.com',
                'password' => '$2y$10$iWUvxwkwd4lqcw1.RaamKuW2JFBtS3oAbuYsLCHFRyNTghFZbZQCa',
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
                'updated_at' => '2017-08-01 12:02:15',
            ),
        ));
        
        
    }
}