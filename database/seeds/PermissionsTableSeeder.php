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
                'group_id' => 2,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'create_permissions',
                'group_id' => 2,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'edit_permissions',
                'group_id' => 2,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'delete_permissions',
                'group_id' => 2,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'view_users',
                'group_id' => 1,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'create_users',
                'group_id' => 1,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'edit_users',
                'group_id' => 1,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'edit_passwords_users',
                'group_id' => 1,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'retire_users',
                'group_id' => 1,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            9 => 
            array (
                'id' => 10,
                'title' => 'delete_users',
                'group_id' => 1,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            10 => 
            array (
                'id' => 11,
                'title' => 'view_assets',
                'group_id' => 3,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            11 => 
            array (
                'id' => 12,
                'title' => 'upload_assets',
                'group_id' => 3,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            12 => 
            array (
                'id' => 13,
                'title' => 'edit_assets',
                'group_id' => 3,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            13 => 
            array (
                'id' => 14,
                'title' => 'move_assets',
                'group_id' => 3,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            14 => 
            array (
                'id' => 15,
                'title' => 'delete_assets',
                'group_id' => 3,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            15 => 
            array (
                'id' => 16,
                'title' => 'view_statuses',
                'group_id' => 4,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            16 => 
            array (
                'id' => 17,
                'title' => 'create_statuses',
                'group_id' => 4,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            17 => 
            array (
                'id' => 18,
                'title' => 'edit_statuses',
                'group_id' => 4,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            18 => 
            array (
                'id' => 19,
                'title' => 'delete_statuses',
                'group_id' => 4,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            19 => 
            array (
                'id' => 20,
                'title' => 'view_roles',
                'group_id' => 5,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            20 => 
            array (
                'id' => 21,
                'title' => 'create_roles',
                'group_id' => 5,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            21 => 
            array (
                'id' => 22,
                'title' => 'edit_roles',
                'group_id' => 5,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            22 => 
            array (
                'id' => 23,
                'title' => 'delete_roles',
                'group_id' => 5,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            23 => 
            array (
                'id' => 24,
                'title' => 'view_orders',
                'group_id' => 6,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            24 => 
            array (
                'id' => 25,
                'title' => 'create_orders',
                'group_id' => 6,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            25 => 
            array (
                'id' => 26,
                'title' => 'view_orders',
                'group_id' => 6,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            26 => 
            array (
                'id' => 28,
                'title' => 'view_articles',
                'group_id' => 7,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            27 => 
            array (
                'id' => 29,
                'title' => 'create_articles',
                'group_id' => 7,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            28 => 
            array (
                'id' => 30,
                'title' => 'edit_articles',
                'group_id' => 7,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            29 => 
            array (
                'id' => 31,
                'title' => 'delete_articles',
                'group_id' => 7,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            30 => 
            array (
                'id' => 32,
                'title' => 'view_pages',
                'group_id' => 8,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            31 => 
            array (
                'id' => 33,
                'title' => 'create_pages',
                'group_id' => 8,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            32 => 
            array (
                'id' => 34,
                'title' => 'edit_pages',
                'group_id' => 8,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            33 => 
            array (
                'id' => 35,
                'title' => 'delete_pages',
                'group_id' => 8,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            34 => 
            array (
                'id' => 36,
                'title' => 'view_companies',
                'group_id' => 9,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            35 => 
            array (
                'id' => 37,
                'title' => 'create_companies',
                'group_id' => 9,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            36 => 
            array (
                'id' => 38,
                'title' => 'edit_companies',
                'group_id' => 9,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            37 => 
            array (
                'id' => 39,
                'title' => 'delete_companies',
                'group_id' => 9,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            38 => 
            array (
                'id' => 40,
                'title' => 'view_locations',
                'group_id' => 10,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            39 => 
            array (
                'id' => 41,
                'title' => 'create_locations',
                'group_id' => 10,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            40 => 
            array (
                'id' => 42,
                'title' => 'edit_locations',
                'group_id' => 10,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            41 => 
            array (
                'id' => 43,
                'title' => 'retire_locations',
                'group_id' => 10,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            42 => 
            array (
                'id' => 44,
                'title' => 'delete_locations',
                'group_id' => 10,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            43 => 
            array (
                'id' => 45,
                'title' => 'view_categories',
                'group_id' => 11,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            44 => 
            array (
                'id' => 46,
                'title' => 'create_categories',
                'group_id' => 11,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            45 => 
            array (
                'id' => 47,
                'title' => 'edit_categories',
                'group_id' => 11,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            46 => 
            array (
                'id' => 48,
                'title' => 'delete_categories',
                'group_id' => 11,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            47 => 
            array (
                'id' => 49,
                'title' => 'view_templates',
                'group_id' => 12,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            48 => 
            array (
                'id' => 50,
                'title' => 'create_templates',
                'group_id' => 12,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            49 => 
            array (
                'id' => 51,
                'title' => 'edit_templates',
                'group_id' => 12,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            50 => 
            array (
                'id' => 52,
                'title' => 'delete_templates',
                'group_id' => 12,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            51 => 
            array (
                'id' => 53,
                'title' => 'view_products',
                'group_id' => 13,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            52 => 
            array (
                'id' => 54,
                'title' => 'create_products',
                'group_id' => 13,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            53 => 
            array (
                'id' => 55,
                'title' => 'edit_products',
                'group_id' => 13,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            54 => 
            array (
                'id' => 56,
                'title' => 'delete_products',
                'group_id' => 13,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            55 => 
            array (
                'id' => 57,
                'title' => 'view_carts',
                'group_id' => 14,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
            56 => 
            array (
                'id' => 59,
                'title' => 'suspend_locations',
                'group_id' => 10,
                'created_at' => '2017-08-01 09:19:39',
                'updated_at' => '2017-08-01 09:19:39',
            ),
        ));
        
        
    }
}