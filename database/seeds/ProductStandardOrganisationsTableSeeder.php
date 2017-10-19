<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

use Illuminate\Database\Seeder;
use App\Http\Transformers\ProductTransformer;

class ProductStandardOrganisationsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_standard_organisations')->delete();
		
		$productStandardOrganisations = json_decode(file_get_contents('database/data/standards_organisations.json'), true);
		
		$productStandardOrganisations = ProductTransformer::transformProductStandardOrganisations($productStandardOrganisations);
		
		collect($productStandardOrganisations)->each(function ($productStandardOrganisation) {
			DB::table('product_standard_organisations')->insert($productStandardOrganisation);
		});
	}
}
