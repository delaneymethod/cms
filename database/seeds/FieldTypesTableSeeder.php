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
                'title' => 'Text',
                'type' => 'text',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Text - Multiline',
                'type' => 'textarea',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Text - Rich',
                'type' => 'textarea',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Number',
                'type' => 'number',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Password',
                'type' => 'password',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Select',
                'type' => 'select',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'Select - Multi',
                'type' => 'select',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'Radio',
                'type' => 'radio',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'Checkbox',
                'type' => 'checkbox',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
        ));
        
        
    }
}