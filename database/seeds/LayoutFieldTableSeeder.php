<?php

use Illuminate\Database\Seeder;

class OrderProductTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('layout_field')->delete();
        
        \DB::table('layout_field')->insert(array (
            0 => 
            array (
                'layout_id' => 1,
                'field_id' => 1,
            ),
            1 => 
            array (
                'layout_id' => 2,
                'field_id' => 2,
            ),
            2 => 
            array (
                'layout_id' => 3,
                'field_id' => 3,
            ),
            3 => 
            array (
                'layout_id' => 4,
                'field_id' => 4,
            ),
            4 => 
            array (
                'layout_id' => 5,
                'field_id' => 5,
            ),
            5 => 
            array (
                'layout_id' => 6,
                'field_id' => 6,
            ),
            6 => 
            array (
                'layout_id' => 7,
                'field_id' => 7,
            ),
            7 => 
            array (
                'layout_id' => 8,
                'field_id' => 8,
            ),
        ));
        
        
    }
}