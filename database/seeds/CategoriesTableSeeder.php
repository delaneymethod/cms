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
                'updated_at' => '2017-08-01 16:49:21',
            ),
        ));
        
        
    }
}