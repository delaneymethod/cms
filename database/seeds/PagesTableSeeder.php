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
                'template_id' => 1,
                'status_id' => 4,
                'parent_id' => NULL,
                'lft' => 1,
                'rgt' => 2,
                'depth' => 0,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 09:19:40',
                'updated_at' => '2017-08-07 15:05:30',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'About Us',
                'slug' => 'about-us',
                'keywords' => NULL,
                'description' => NULL,
                'content' => '<p>This is the About page.</p>',
                'template_id' => 1,
                'status_id' => 4,
                'parent_id' => NULL,
                'lft' => 3,
                'rgt' => 4,
                'depth' => 0,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 11:51:41',
                'updated_at' => '2017-08-07 15:05:30',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Services',
                'slug' => 'services',
                'keywords' => NULL,
                'description' => NULL,
                'content' => '<p>This is the Services page.</p>',
                'template_id' => 1,
                'status_id' => 4,
                'parent_id' => NULL,
                'lft' => 5,
                'rgt' => 6,
                'depth' => 0,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 11:51:58',
                'updated_at' => '2017-08-07 15:05:30',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Products',
                'slug' => 'products',
                'keywords' => '',
                'description' => NULL,
                'content' => '<p>This is the Products page.</p>',
                'template_id' => 2,
                'status_id' => 4,
                'parent_id' => NULL,
                'lft' => 7,
                'rgt' => 8,
                'depth' => 0,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 11:51:58',
                'updated_at' => '2017-08-07 15:05:30',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Cart',
                'slug' => 'cart',
                'keywords' => '',
                'description' => NULL,
                'content' => '<p>This is the Cart page.</p>',
                'template_id' => 6,
                'status_id' => 4,
                'parent_id' => NULL,
                'lft' => 9,
                'rgt' => 14,
                'depth' => 0,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 11:51:58',
                'updated_at' => '2017-08-07 15:05:30',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Checkout',
                'slug' => 'checkout',
                'keywords' => '',
                'description' => NULL,
                'content' => '<p>This is the Checkout page.</p>',
                'template_id' => 5,
                'status_id' => 4,
                'parent_id' => 5,
                'lft' => 10,
                'rgt' => 13,
                'depth' => 1,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 11:51:58',
                'updated_at' => '2017-08-07 15:05:30',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'Success',
                'slug' => 'success',
                'keywords' => NULL,
                'description' => NULL,
                'content' => '<p>This is the Success page.</p>',
                'template_id' => 1,
                'status_id' => 4,
                'parent_id' => 6,
                'lft' => 11,
                'rgt' => 12,
                'depth' => 2,
                'hide_from_nav' => 0,
                'created_at' => '2017-08-01 11:51:58',
                'updated_at' => '2017-08-07 15:05:30',
            ),
        ));
        
        
    }
}