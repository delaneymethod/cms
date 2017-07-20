<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->call(PermissionsTableSeeder::class);
		$this->call(CountriesTableSeeder::class);
		$this->call(CountiesTableSeeder::class);
		$this->call(StatusesTableSeeder::class);
		$this->call(LocationsTableSeeder::class);
		$this->call(RolesTableSeeder::class);
		$this->call(UsersTableSeeder::class);
		$this->call(PermissionUserTableSeeder::class);
		$this->call(PagesTableSeeder::class);
		$this->call(OrdersTableSeeder::class);
		$this->call(ArticlesTableSeeder::class);
		$this->call(AssetsTableSeeder::class);
    }
}
