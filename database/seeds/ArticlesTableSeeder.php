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
                'content' => '<p>My First Blog Post.</p>',
                'user_id' => 1,
                'status_id' => 1,
                'created_at' => '2017-08-01 09:19:40',
                'updated_at' => '2017-08-01 09:19:40',
            ),
        ));
        
        
    }
}