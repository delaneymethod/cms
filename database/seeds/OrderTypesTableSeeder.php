<?php

use Illuminate\Database\Seeder;

class OrderTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('order_types')->delete();
        
        \DB::table('order_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Web',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
        ));
        
        
    }
}