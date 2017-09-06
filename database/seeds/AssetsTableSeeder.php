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
                'id' => 9,
                'filename' => '12047166_10205956784292022_3614506525290593747_n.jpg',
                'extension' => 'jpeg',
                'mime_type' => 'image/jpeg',
                'path' => '/uploads/12047166_10205956784292022_3614506525290593747_n.jpg',
                'size' => 31938,
                'created_at' => '2017-08-31 15:08:49',
                'updated_at' => '2017-08-31 16:45:54',
            ),
        ));
        
        
    }
}