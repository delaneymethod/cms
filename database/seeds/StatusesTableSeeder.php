<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('statuses')->delete();
        
        \DB::table('statuses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Active',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Pending',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Retired',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Published',
                'created_at' => '2017-08-02 17:02:11',
                'updated_at' => '2017-08-02 17:02:11',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Private',
                'created_at' => '2017-08-02 17:02:16',
                'updated_at' => '2017-08-02 17:02:16',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Draft',
                'created_at' => '2017-08-02 17:02:23',
                'updated_at' => '2017-08-02 17:02:23',
            ),
        ));
        
        
    }
}