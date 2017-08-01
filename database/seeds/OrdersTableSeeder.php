<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('orders')->delete();
        
        \DB::table('orders')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'My First Order',
                'user_id' => 1,
                'status_id' => 1,
                'created_at' => '2017-08-01 09:19:40',
                'updated_at' => '2017-08-01 09:19:40',
            ),
        ));
        
        
    }
}