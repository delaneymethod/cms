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
		$this->call(GroupsTableSeeder::class);
		$this->call(PermissionsTableSeeder::class);
		$this->call(CountriesTableSeeder::class);
		$this->call(CountiesTableSeeder::class);
		$this->call(StatusesTableSeeder::class);
		$this->call(CompaniesTableSeeder::class);
		$this->call(LocationsTableSeeder::class);
		$this->call(RolesTableSeeder::class);
		$this->call(TemplatesTableSeeder::class);
		$this->call(UsersTableSeeder::class);
		$this->call(PagesTableSeeder::class);
		$this->call(ShippingMethodsTableSeeder::class);
		$this->call(OrderTypesTableSeeder::class);
		$this->call(OrdersTableSeeder::class);
		$this->call(ArticlesTableSeeder::class);
		$this->call(AssetsTableSeeder::class);
		$this->call(RolePermissionTableSeeder::class);
		$this->call(CategoriesTableSeeder::class);
		$this->call(ArticleCategoryTableSeeder::class);
		$this->call(CartsTableSeeder::class);
		$this->call(ProductsTableSeeder::class);
		$this->call(OrderProductTableSeeder::class);
		$this->call(FieldTypesTableSeeder::class);
		$this->call(FieldsTableSeeder::class);
		$this->call(TemplateFieldTableSeeder::class);
		$this->call(ContentsTableSeeder::class);
		$this->call(PageContentTableSeeder::class);
		$this->call(ArticleContentTableSeeder::class);
	}
}
