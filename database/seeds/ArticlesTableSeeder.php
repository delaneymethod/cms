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
                'keywords' => NULL,
                'description' => NULL,
                'template_id' => 8,
                'user_id' => 1,
                'status_id' => 6,
                'published_at' => '2017-08-02 18:22:31',
                'created_at' => '2017-08-11 10:00:00',
                'updated_at' => '2017-08-02 18:16:33',
            ),
        ));
        
        
    }
}