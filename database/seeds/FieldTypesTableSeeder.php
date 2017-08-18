<?php

use Illuminate\Database\Seeder;

class FieldTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('field_types')->delete();
        
        \DB::table('field_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Plain Text',
                'filename' => 'plain_text',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Rich Text',
                'filename' => 'rich_text',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
        ));
        
        
    }
}