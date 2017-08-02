<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('companies')->delete();
        
        \DB::table('companies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'DelaneyMethod Web Development Ltd',
                'default_location_id' => 2,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-02 13:03:22',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Grampian Fasteners',
                'default_location_id' => 1,
                'created_at' => '2017-08-01 12:01:53',
                'updated_at' => '2017-08-02 12:42:15',
            ),
        ));
        
        
    }
}