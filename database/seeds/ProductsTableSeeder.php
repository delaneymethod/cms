<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('products')->delete();
		
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$products = json_decode(file_get_contents('database/data/products.json'), true);
		
		foreach ($products as $product) {
			DB::table('products')->insert([
				'id' => $product['Id'],
				'title' => $product['Name'],
				'sort_order' => $product['SortOrder'],
				'product_category_id' => $product['CategoryId'],
				'product_manufacturer_id' => $product['ManufacturerId'],
				'harmonised_code_id' => $product['HarmonisedCodeId'],
				'supplier_id' => $product['SupplierId'],
				'product_vat_rate_id' => $product['VatRateId'],
				'limited_life' => $product['LimitedLife'],
				'test_certificates_required' => $product['TestCertificatesRequired'],
				'commodity_name_protocol' => $product['CommodityNameProtocol'],
				'commodity_code_protocol' => $product['CommodityCodeProtocol'],
				'commodity_short_description_protocol' => $product['CommodityShortDescriptionProtocol'],
				'retire_date' => $product['RetireDate'],
				'retire_employee_id' => $product['RetireEmployeeId'],
				'description' => $product['Description'],
				'short_name' => $product['ShortName'],
				'image_uri' => $product['ImageURI'],
				'created_at' => $now,
				'updated_at' => $now,
			]);
		}
	}
}
