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
                'company_id' => 2,
                'status_id' => 1,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-02 12:38:55',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Westhill Office',
                'unit' => '',
                'building' => '',
                'street_address_1' => '3 Oak Crescent',
                'street_address_2' => '',
                'street_address_3' => '',
                'street_address_4' => '',
                'town_city' => 'Westhill',
                'postal_code' => 'AB32 6WQ',
                'telephone' => '+44 1224 123 456',
                'county_id' => 34,
                'country_id' => 3,
                'company_id' => 1,
                'status_id' => 1,
                'created_at' => '2017-08-01 11:53:39',
                'updated_at' => '2017-08-02 12:39:08',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Echt Office',
                'unit' => '',
                'building' => '',
                'street_address_1' => 'Test',
                'street_address_2' => '',
                'street_address_3' => '',
                'street_address_4' => '',
                'town_city' => 'Test',
                'postal_code' => '',
                'telephone' => '+44 1224 123 456',
                'county_id' => 1,
                'country_id' => 1,
                'company_id' => 2,
                'status_id' => 1,
                'created_at' => '2017-08-02 12:36:01',
                'updated_at' => '2017-09-06 16:14:22',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Roscrea Office',
                'unit' => '',
                'building' => '',
                'street_address_1' => 'Test',
                'street_address_2' => '',
                'street_address_3' => '',
                'street_address_4' => '',
                'town_city' => 'Test',
                'postal_code' => '',
                'telephone' => '+353 505 22627',
                'county_id' => 22,
                'country_id' => 1,
                'company_id' => 1,
                'status_id' => 1,
                'created_at' => '2017-08-02 13:00:58',
                'updated_at' => '2017-09-06 16:14:32',
            ),
        ));
        
        
    }
}