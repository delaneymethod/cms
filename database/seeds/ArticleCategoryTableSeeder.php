<?php

use Illuminate\Database\Seeder;

class ArticleCategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('article_category')->delete();
        
        \DB::table('article_category')->insert(array (
            0 => 
            array (
                'article_id' => 1,
                'category_id' => 1,
            ),
            1 => 
            array (
                'article_id' => 1,
                'category_id' => 5,
            ),
            2 => 
            array (
                'article_id' => 1,
                'category_id' => 2,
            ),
        ));
        
        
    }
}