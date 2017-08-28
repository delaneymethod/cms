<?php

use Illuminate\Database\Seeder;

class FieldsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('fields')->delete();
        
        \DB::table('fields')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Content',
                'handle' => 'content',
                'instructions' => NULL,
                'options' => NULL,
                'field_type_id' => 3,
                'required' => 0,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Content',
                'handle' => 'content',
                'instructions' => NULL,
                'options' => NULL,
                'field_type_id' => 3,
                'required' => 0,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Content',
                'handle' => 'content',
                'instructions' => NULL,
                'options' => NULL,
                'field_type_id' => 3,
                'required' => 0,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Content',
                'handle' => 'content',
                'instructions' => NULL,
                'options' => NULL,
                'field_type_id' => 3,
                'required' => 0,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Content',
                'handle' => 'content',
                'instructions' => NULL,
                'options' => NULL,
                'field_type_id' => 3,
                'required' => 0,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Content',
                'handle' => 'content',
                'instructions' => NULL,
                'options' => NULL,
                'field_type_id' => 3,
                'required' => 0,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'Content',
                'handle' => 'content',
                'instructions' => NULL,
                'options' => NULL,
                'field_type_id' => 3,
                'required' => 0,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'Content',
                'handle' => 'content',
                'instructions' => NULL,
                'options' => NULL,
                'field_type_id' => 3,
                'required' => 0,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'Content',
                'handle' => 'content',
                'instructions' => NULL,
                'options' => NULL,
                'field_type_id' => 3,
                'required' => 0,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            9 => 
            array (
                'id' => 10,
                'title' => 'Excerpt',
                'handle' => 'excerpt',
                'instructions' => NULL,
                'options' => NULL,
                'field_type_id' => 2,
                'required' => 0,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
        ));
        
        
    }
}