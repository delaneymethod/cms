<?php

use Illuminate\Database\Seeder;

class TemplateFieldTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('template_field')->delete();
        
        \DB::table('template_field')->insert(array (
            0 => 
            array (
                'template_id' => 1,
                'field_id' => 1,
                'order' => 2,
            ),
            1 => 
            array (
                'template_id' => 2,
                'field_id' => 2,
                'order' => 1,
            ),
            2 => 
            array (
                'template_id' => 3,
                'field_id' => 3,
                'order' => 1,
            ),
            3 => 
            array (
                'template_id' => 4,
                'field_id' => 4,
                'order' => 1,
            ),
            4 => 
            array (
                'template_id' => 5,
                'field_id' => 5,
                'order' => 1,
            ),
            5 => 
            array (
                'template_id' => 6,
                'field_id' => 6,
                'order' => 1,
            ),
            6 => 
            array (
                'template_id' => 7,
                'field_id' => 7,
                'order' => 1,
            ),
            7 => 
            array (
                'template_id' => 8,
                'field_id' => 8,
                'order' => 1,
            ),
            8 => 
            array (
                'template_id' => 9,
                'field_id' => 9,
                'order' => 2,
            ),
            9 => 
            array (
                'template_id' => 9,
                'field_id' => 10,
                'order' => 1,
            ),
        ));
        
        
    }
}