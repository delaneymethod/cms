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
                'template_id' => 1,
                'status_id' => 4,
                'parent_id' => NULL,
                'lft' => 1,
                'rgt' => 2,
                'depth' => 0,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 09:19:40',
                'updated_at' => '2017-08-25 16:32:04',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'About Us',
                'slug' => 'about-us',
                'keywords' => '',
                'description' => NULL,
                'template_id' => 2,
                'status_id' => 4,
                'parent_id' => NULL,
                'lft' => 3,
                'rgt' => 6,
                'depth' => 0,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 11:51:41',
                'updated_at' => '2017-08-25 16:32:04',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Services',
                'slug' => 'services',
                'keywords' => NULL,
                'description' => NULL,
                'template_id' => 2,
                'status_id' => 4,
                'parent_id' => NULL,
                'lft' => 7,
                'rgt' => 8,
                'depth' => 0,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 11:51:58',
                'updated_at' => '2017-08-25 16:32:04',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Products',
                'slug' => 'products',
                'keywords' => '',
                'description' => NULL,
                'template_id' => 3,
                'status_id' => 4,
                'parent_id' => NULL,
                'lft' => 9,
                'rgt' => 10,
                'depth' => 0,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 11:51:58',
                'updated_at' => '2017-08-25 16:32:04',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Cart',
                'slug' => 'cart',
                'keywords' => '',
                'description' => NULL,
                'template_id' => 6,
                'status_id' => 4,
                'parent_id' => NULL,
                'lft' => 11,
                'rgt' => 16,
                'depth' => 0,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 11:51:58',
                'updated_at' => '2017-08-25 16:32:04',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Checkout',
                'slug' => 'checkout',
                'keywords' => '',
                'description' => NULL,
                'template_id' => 7,
                'status_id' => 4,
                'parent_id' => 5,
                'lft' => 12,
                'rgt' => 15,
                'depth' => 1,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 11:51:58',
                'updated_at' => '2017-08-25 16:32:04',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'Success',
                'slug' => 'success',
                'keywords' => NULL,
                'description' => NULL,
                'template_id' => 2,
                'status_id' => 4,
                'parent_id' => 6,
                'lft' => 13,
                'rgt' => 14,
                'depth' => 2,
                'hide_from_nav' => 1,
                'created_at' => '2017-08-01 11:51:58',
                'updated_at' => '2017-08-25 16:32:04',
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'Hidden from Nav',
                'slug' => 'hidden-from-nav',
                'keywords' => NULL,
                'description' => NULL,
                'template_id' => 2,
                'status_id' => 4,
                'parent_id' => NULL,
                'lft' => 17,
                'rgt' => 18,
                'depth' => 0,
                'hide_from_nav' => 1,
                'created_at' => '2017-08-01 11:51:58',
                'updated_at' => '2017-08-25 16:32:05',
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'Articles',
                'slug' => 'articles',
                'keywords' => NULL,
                'description' => NULL,
                'template_id' => 8,
                'status_id' => 4,
                'parent_id' => NULL,
                'lft' => 19,
                'rgt' => 20,
                'depth' => 0,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 11:51:58',
                'updated_at' => '2017-08-25 16:32:05',
            ),
            9 => 
            array (
                'id' => 10,
                'title' => 'Sean&#39;s Test Page',
                'slug' => 'seans-test-page',
                'keywords' => 'Sean\'s,Test,Page',
                'description' => NULL,
                'template_id' => 2,
                'status_id' => 4,
                'parent_id' => 2,
                'lft' => 4,
                'rgt' => 5,
                'depth' => 1,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-25 16:20:43',
                'updated_at' => '2017-08-25 16:32:04',
            ),
        ));
        
        
    }
}