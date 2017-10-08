<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class DbImport extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'db:import';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Imports data from general.sql located in /database/data';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		return DB::unprepared(file_get_contents(database_path('data').DIRECTORY_SEPARATOR.'general.sql')); 
	}
}
