<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('locations')->delete();
        
        \DB::table('locations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Dyce, Aberdeen',
                'unit' => '',
                'building' => 'Grampian House',
                'street_address_1' => 'Pitmedden Road',
                'street_address_2' => 'Dyce',
                'street_address_3' => '',
                'street_address_4' => '',
                'town_city' => 'Aberdeen',
                'postal_code' => 'AB21 0DP',
                'telephone' => '+44 1224 772 777',
                'county_id' => 33,
                'country_id' => 3,
                'company_id' => 1,
                'status_id' => 1,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Westhill Office',
                'unit' => NULL,
                'building' => NULL,
                'street_address_1' => '3 Oak Crescent',
                'street_address_2' => NULL,
                'street_address_3' => NULL,
                'street_address_4' => NULL,
                'town_city' => 'Westhill',
                'postal_code' => 'AB32 6WQ',
                'telephone' => '+44 1224 123 456',
                'county_id' => 34,
                'country_id' => 3,
                'company_id' => 1,
                'status_id' => 1,
                'created_at' => '2017-08-01 11:53:39',
                'updated_at' => '2017-08-01 11:54:59',
            ),
        ));
        
        
    }
}