<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'view_permissions',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'create_permissions',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'edit_permissions',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'delete_permissions',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'view_users',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'create_users',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'edit_users',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'edit_passwords_users',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'retire_users',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            9 => 
            array (
                'id' => 10,
                'title' => 'delete_users',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            10 => 
            array (
                'id' => 11,
                'title' => 'view_assets',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            11 => 
            array (
                'id' => 12,
                'title' => 'upload_assets',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            12 => 
            array (
                'id' => 13,
                'title' => 'delete_assets',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            13 => 
            array (
                'id' => 14,
                'title' => 'view_statuses',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            14 => 
            array (
                'id' => 15,
                'title' => 'create_statuses',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            15 => 
            array (
                'id' => 16,
                'title' => 'edit_statuses',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            16 => 
            array (
                'id' => 17,
                'title' => 'delete_statuses',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            17 => 
            array (
                'id' => 18,
                'title' => 'view_roles',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            18 => 
            array (
                'id' => 19,
                'title' => 'create_roles',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            19 => 
            array (
                'id' => 20,
                'title' => 'edit_roles',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            20 => 
            array (
                'id' => 21,
                'title' => 'delete_roles',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            21 => 
            array (
                'id' => 22,
                'title' => 'view_orders',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            22 => 
            array (
                'id' => 23,
                'title' => 'create_orders',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            23 => 
            array (
                'id' => 24,
                'title' => 'edit_orders',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            24 => 
            array (
                'id' => 25,
                'title' => 'delete_orders',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            25 => 
            array (
                'id' => 26,
                'title' => 'view_articles',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            26 => 
            array (
                'id' => 27,
                'title' => 'create_articles',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            27 => 
            array (
                'id' => 28,
                'title' => 'edit_articles',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            28 => 
            array (
                'id' => 29,
                'title' => 'delete_articles',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            29 => 
            array (
                'id' => 30,
                'title' => 'view_pages',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            30 => 
            array (
                'id' => 31,
                'title' => 'create_pages',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            31 => 
            array (
                'id' => 32,
                'title' => 'edit_pages',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            32 => 
            array (
                'id' => 33,
                'title' => 'delete_pages',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            33 => 
            array (
                'id' => 34,
                'title' => 'view_companies',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            34 => 
            array (
                'id' => 35,
                'title' => 'create_companies',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            35 => 
            array (
                'id' => 36,
                'title' => 'edit_companies',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            36 => 
            array (
                'id' => 37,
                'title' => 'delete_companies',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            37 => 
            array (
                'id' => 38,
                'title' => 'view_locations',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            38 => 
            array (
                'id' => 39,
                'title' => 'create_locations',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            39 => 
            array (
                'id' => 40,
                'title' => 'edit_locations',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            40 => 
            array (
                'id' => 41,
                'title' => 'retire_locations',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            41 => 
            array (
                'id' => 42,
                'title' => 'delete_locations',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            42 => 
            array (
                'id' => 43,
                'title' => 'view_categories',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            43 => 
            array (
                'id' => 44,
                'title' => 'create_categories',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            44 => 
            array (
                'id' => 45,
                'title' => 'edit_categories',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            45 => 
            array (
                'id' => 46,
                'title' => 'delete_categories',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            46 => 
            array (
                'id' => 47,
                'title' => 'view_templates',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            47 => 
            array (
                'id' => 48,
                'title' => 'create_templates',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            48 => 
            array (
                'id' => 49,
                'title' => 'edit_templates',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            49 => 
            array (
                'id' => 50,
                'title' => 'delete_templates',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            50 => 
            array (
                'id' => 51,
                'title' => 'view_products',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            51 => 
            array (
                'id' => 52,
                'title' => 'create_products',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            52 => 
            array (
                'id' => 53,
                'title' => 'edit_products',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            53 => 
            array (
                'id' => 54,
                'title' => 'delete_products',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            54 => 
            array (
                'id' => 55,
                'title' => 'view_carts',
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
        ));
        
        
    }
}