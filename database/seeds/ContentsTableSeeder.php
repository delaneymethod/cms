<?php

use Illuminate\Database\Seeder;

class ContentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('contents')->delete();
        
        \DB::table('contents')->insert(array (
            0 => 
            array (
                'id' => 4,
                'field_id' => 1,
                'data' => '<p>This is the Homepage.</p>',
                'created_at' => '2017-08-24 15:46:23',
                'updated_at' => '2017-08-24 15:46:23',
            ),
            1 => 
            array (
                'id' => 25,
                'field_id' => 2,
                'data' => '<p>This is the About page.</p>',
                'created_at' => '2017-08-25 16:03:52',
                'updated_at' => '2017-08-25 16:03:52',
            ),
            2 => 
            array (
                'id' => 37,
                'field_id' => 2,
                'data' => '<p>This is Sean\'s test page.</p>',
                'created_at' => '2017-08-25 16:28:23',
                'updated_at' => '2017-08-25 16:28:23',
            ),
            3 => 
            array (
                'id' => 42,
                'field_id' => 10,
                'data' => 'This is an example excerpt field.',
                'created_at' => '2017-08-28 08:48:16',
                'updated_at' => '2017-08-28 08:48:16',
            ),
            4 => 
            array (
                'id' => 43,
                'field_id' => 9,
                'data' => '<p>This<em> is</em> an <del>example</del> <strong>content</strong> field.</p>',
                'created_at' => '2017-08-28 08:48:16',
                'updated_at' => '2017-08-28 08:48:16',
            ),
        ));
        
        
    }
}