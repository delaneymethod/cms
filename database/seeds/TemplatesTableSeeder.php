<?php

use Illuminate\Database\Seeder;

class TemplatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('templates')->delete();
        
        \DB::table('templates')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Page',
                'filename' => 'page',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Products',
                'filename' => 'products',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Contact',
                'filename' => 'contact',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
        ));
        
        
    }
}