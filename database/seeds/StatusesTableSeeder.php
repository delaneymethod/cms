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
                'description' => NULL,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Pending',
                'description' => 'Users with this status cannot login.',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-09-06 14:09:04',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Retired',
                'description' => 'Users with this status cannot login.',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-09-06 14:09:10',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Published',
                'description' => NULL,
                'created_at' => '2017-08-02 17:02:11',
                'updated_at' => '2017-08-02 17:02:11',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Private',
                'description' => 'Articles or Pages with this status will be hidden from any menu/navigation.',
                'created_at' => '2017-08-02 17:02:16',
                'updated_at' => '2017-09-06 13:59:20',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Draft',
                'description' => 'Articles or Pages with this status will be hidden from any menu/navigation.',
                'created_at' => '2017-08-02 17:02:23',
                'updated_at' => '2017-09-06 13:59:30',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'Suspended',
                'description' => 'Users or Locations with this status cannot checkout. However, Users can still login and access the dashboard.',
                'created_at' => '2017-09-06 12:33:07',
                'updated_at' => '2017-09-06 14:06:44',
            ),
        ));
        
        
    }
}