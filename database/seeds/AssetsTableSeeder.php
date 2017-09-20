<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AssetsTableSeeder extends Seeder
{
	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon::now()->format('Y-m-d H:i:s');

		$assets = [
			[
				'filename' => '12047166_10205956784292022_3614506525290593747_n.jpg',
				'extension' => 'jpeg',
				'mime_type' => 'image/jpeg',
				'path' => '/uploads/12047166_10205956784292022_3614506525290593747_n.jpg',
				'size' => 31938,
				'created_at' => $now,
				'updated_at' => $now,
			],
		];
		
		DB::table('assets')->delete();
		
		DB::table('assets')->insert($assets);
	}
}
