<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
 
namespace App\Console\Commands;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Console\Command;
use App\Http\Traits\{PageTrait, ArticleTrait, ProductTrait, ProductCategoryTrait};

class GenerateSitemap extends Command
{
	use PageTrait, ArticleTrait, ProductTrait, ProductCategoryTrait;
	
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'sitemap:generate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate the sitemap.';

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
		$appUrl = config('app.url');
		
		$sitemap = Sitemap::create();
		
		$sitemap->add(Url::create($appUrl)->setPriority(1.0));
		
		// Add pages
		$pages = $this->getPages();
		
		// Remove the home page though as already added this above
		unset($pages[0]);
		
		$pages->each(function ($page) use ($sitemap, $appUrl) {
			$sitemap->add(Url::create($appUrl.$page->url)->setPriority(0.7));
		});
		
		// Add product categories
		$productCategories = $this->getProductCategories();
		
		$productCategories->each(function ($productCategory) use ($sitemap, $appUrl) {
			$sitemap->add(Url::create($appUrl.$productCategory->url)->setPriority(0.8));
		});
		
		// Add products
		$products = $this->getProducts();
		
		$products->each(function ($product) use ($sitemap, $appUrl) {
			$sitemap->add(Url::create($appUrl.$product->url)->setPriority(0.9));
		});
		
		// Add articles
		$articles = $this->getArticles();
		
		$articles->each(function ($article) use ($sitemap, $appUrl) {
			$sitemap->add(Url::create($appUrl.$article->url)->setPriority(0.6));
		});
		
		$sitemap->writeToFile(public_path('sitemap.xml'));
	}
}
