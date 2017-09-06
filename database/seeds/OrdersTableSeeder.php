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
                'order_number' => '1234567890',
                'order_type_id' => 1,
                'user_id' => 1,
                'status_id' => 1,
                'count' => 1,
                'tax' => 26.0,
                'subtotal' => 129.99,
                'total' => 155.99,
                'created_at' => '2017-08-01 09:19:40',
                'updated_at' => '2017-08-01 09:19:40',
            ),
        ));
        
        
    }
}