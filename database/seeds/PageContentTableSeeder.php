<?php

use Illuminate\Database\Seeder;

class PageContentTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('page_content')->delete();
        
        \DB::table('page_content')->insert(array (
            0 => 
            array (
                'page_id' => 1,
                'content_id' => 4,
            ),
            1 => 
            array (
                'page_id' => 2,
                'content_id' => 25,
            ),
            2 => 
            array (
                'page_id' => 10,
                'content_id' => 37,
            ),
        ));
        
        
    }
}