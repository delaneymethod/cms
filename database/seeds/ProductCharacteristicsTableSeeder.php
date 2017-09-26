<?php
	
use Illuminate\Database\Seeder;
use App\Http\Transformers\ProductTransformer;

class ProductCharacteristicsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('product_characteristics')->delete();
		
		$productCharacteristics = json_decode(file_get_contents('database/data/characteristics.json'), true);
		
		$productCharacteristics = ProductTransformer::transformProductCharacteristics($productCharacteristics);
			
		collect($productCharacteristics)->each(function ($productCharacteristic) {
			DB::table('product_characteristics')->insert($productCharacteristic);
		});
		
	}
}
