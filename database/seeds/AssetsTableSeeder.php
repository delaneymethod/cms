<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AssetsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');

		$assets = [
			[
				'title' => 'Banner A',
				'hash_name' => '8wKW37wIWGyDl1acrCUglvbfUQBNEyko5EjHfyZ6.jpeg',
				'original_name' => 'banner_a.jpg',
				'mime_type' => 'image/jpeg',
				'extension' => 'jpg',
				'path' => '/uploads/banner_a.jpg',
				'size' => 670136,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];

		DB::table('assets')->delete();

		DB::table('assets')->insert($assets);
	}
}
