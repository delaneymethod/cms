<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('articles')->delete();
        
        \DB::table('articles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'My First Blog Post',
                'slug' => 'my-first-blog-post',
                'keywords' => 'My,First,Blog,Post',
                'description' => NULL,
                'template_id' => 9,
                'user_id' => 1,
                'status_id' => 1,
                'published_at' => '2017-09-06 12:13:10',
                'created_at' => '2017-08-11 10:00:00',
                'updated_at' => '2017-09-06 12:13:10',
            ),
        ));
        
        
    }
}