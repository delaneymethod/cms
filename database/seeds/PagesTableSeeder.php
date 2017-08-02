<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pages')->delete();
        
        \DB::table('pages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Home',
                'slug' => '',
                'keywords' => NULL,
                'description' => NULL,
                'content' => '<p>This is the homepage.</p>',
                'status_id' => 1,
                'parent_id' => NULL,
                'lft' => 1,
                'rgt' => 2,
                'depth' => 0,
                'created_at' => '2017-08-01 09:19:40',
                'updated_at' => '2017-08-02 12:29:59',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'About Us',
                'slug' => 'about-us',
                'keywords' => NULL,
                'description' => NULL,
                'content' => '<p>This is the About page.</p>',
                'status_id' => 1,
                'parent_id' => NULL,
                'lft' => 3,
                'rgt' => 4,
                'depth' => 0,
                'created_at' => '2017-08-01 11:51:41',
                'updated_at' => '2017-08-02 12:29:59',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Services',
                'slug' => 'services',
                'keywords' => NULL,
                'description' => NULL,
                'content' => '<p>This is the Services page.</p>',
                'status_id' => 1,
                'parent_id' => NULL,
                'lft' => 5,
                'rgt' => 6,
                'depth' => 0,
                'created_at' => '2017-08-01 11:51:58',
                'updated_at' => '2017-08-02 12:29:59',
            ),
        ));
        
        
    }
}