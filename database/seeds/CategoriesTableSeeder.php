<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'All Categories',
                'slug' => 'all-categories',
                'status_id' => 1,
                'created_at' => '2017-08-01 16:49:21',
                'updated_at' => '2017-08-02 10:50:52',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Brands',
                'slug' => 'brands',
                'status_id' => 1,
                'created_at' => '2017-08-31 17:19:34',
                'updated_at' => '2017-08-31 17:20:38',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Company News',
                'slug' => 'company-news',
                'status_id' => 1,
                'created_at' => '2017-08-31 17:20:18',
                'updated_at' => '2017-08-31 17:20:18',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Technical',
                'slug' => 'technical',
                'status_id' => 1,
                'created_at' => '2017-08-31 17:20:29',
                'updated_at' => '2017-08-31 17:20:29',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Products',
                'slug' => 'products',
                'status_id' => 1,
                'created_at' => '2017-08-31 17:20:45',
                'updated_at' => '2017-08-31 17:20:45',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Tips / Guides',
                'slug' => 'tips-guides',
                'status_id' => 1,
                'created_at' => '2017-08-31 17:20:53',
                'updated_at' => '2017-08-31 17:20:53',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'International',
                'slug' => 'international',
                'status_id' => 1,
                'created_at' => '2017-08-31 17:21:01',
                'updated_at' => '2017-08-31 17:21:01',
            ),
        ));
        
        
    }
}