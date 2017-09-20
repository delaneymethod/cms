<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductManufacturersTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_manufacturers')->delete();
		
		$now = Carbon::now()->format('Y-m-d H:i:s');
		
		$manufacturers = json_decode(file_get_contents('database/data/manufacturers.json'), true);
		
		foreach ($manufacturers as $manufacturer) {
			DB::table('product_manufacturers')->insert([
				'id' => $manufacturer['Id'],
				'title' => $manufacturer['Name'],
				'website' => str_replace('http://http://', 'http://', $manufacturer['Website']),
				'logo_image' => $manufacturer['LogoImage'],
				'cms_page_name' => $manufacturer['CMSPageName'],
				'created_at' => $now,
				'updated_at' => $now,
			]);
		}
	}
}
