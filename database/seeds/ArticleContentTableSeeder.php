<?php

use Illuminate\Database\Seeder;

class ArticleContentTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('article_content')->delete();
        
        \DB::table('article_content')->insert(array (
            0 => 
            array (
                'article_id' => 1,
                'content_id' => 52,
            ),
            1 => 
            array (
                'article_id' => 1,
                'content_id' => 53,
            ),
        ));
        
        
    }
}