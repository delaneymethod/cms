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
		ini_set('memory_limit', '1048M');
		
		DB::disableQueryLog();
		
		$this->call(PermissionGroupsTableSeeder::class);
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
		$this->call(ArticleCategoriesTableSeeder::class);
		$this->call(ArticleCategoryTableSeeder::class);
		$this->call(CartsTableSeeder::class);
		$this->call(ProductAttributesTableSeeder::class);
		$this->call(ProductStandardOrganisationsTableSeeder::class);
		$this->call(ProductStandardsTableSeeder::class);
		$this->call(ProductCategoriesTableSeeder::class);
		$this->call(ProductManufacturersTableSeeder::class);
		$this->call(ProductVatRatesTableSeeder::class);
		$this->call(ProductsTableSeeder::class);
		$this->call(ProductCharacteristicsTableSeeder::class);
		$this->call(ProductStandardTableSeeder::class);
		$this->call(ProductAttributeTableSeeder::class);
		$this->call(FieldTypesTableSeeder::class);
		$this->call(FieldsTableSeeder::class);
		$this->call(TemplateFieldTableSeeder::class);
		$this->call(ContentsTableSeeder::class);
		$this->call(PageContentTableSeeder::class);
		$this->call(ArticleContentTableSeeder::class);
		$this->call(ProductCommoditiesTableSeeder::class);
		$this->call(OrderProductCommodityTableSeeder::class);
		$this->call(KeywordsTableSeeder::class);
		$this->call(GlobalsTableSeeder::class);
		
		DB::enableQueryLog();
	}
}
