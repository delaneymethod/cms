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
        

        \DB::table('order_product')->delete();
        
        \DB::table('order_product')->insert(array (
            0 => 
            array (
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 1,
                'tax_rate' => 20,
                'price' => 129.99,
                'price_tax' => 155.99,
            ),
        ));
        
        
    }
}