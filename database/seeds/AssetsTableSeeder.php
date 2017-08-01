<?php

use Illuminate\Database\Seeder;

class AssetsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('assets')->delete();
        
        \DB::table('assets')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Banner A',
                'hash_name' => '8wKW37wIWGyDl1acrCUglvbfUQBNEyko5EjHfyZ6.jpeg',
                'original_name' => 'banner_a.jpg',
                'mime_type' => 'image/jpeg',
                'extension' => 'jpg',
                'path' => '/uploads/banner_a.jpg',
                'size' => 670136,
                'created_at' => '2017-08-01 09:19:40',
                'updated_at' => '2017-08-01 09:19:40',
            ),
        ));
        
        
    }
}