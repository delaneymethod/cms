<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */

namespace App\Http\Traits;

use App\Models\{Page, Template};
use Illuminate\Database\Eloquent\Collection as CollectionResponse;
use App\Templates\{CartTemplate, PageTemplate, ContactTemplate, ProductTemplate, ProductsTemplate, ArticleTemplate, CheckoutTemplate, ArticlesTemplate, HomepageTemplate, ProductSearchTemplate, ProductCategoryTemplate, ProductManufacturerTemplate, ProductManufacturersTemplate};

trait TemplateTrait
{
	/**
	 * Get the specified template based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getTemplate(int $id) : Template
	{
		return Template::findOrFail($id);
	}
	
	/**
	 * Get the specified template based on filename.
	 *
	 * @param 	string 		$filename
	 * @return 	Object
	 */
	public function getTemplateByFilename(string $filename) : Template
	{
		return Template::where('filename', $filename)->firstOrFail();
	}

	/**
	 * Get all the templates.
	 *
	 * @return 	Response
	 */
	public function getTemplates() : CollectionResponse
	{
		return Template::all();
	}
	
	/**
	 * Get a pages template and injects data based on said template.
	 *
	 * @return 	void
	 */
	protected function preparePageTemplate(Page $page, array $parameters)
	{
		// Since individual products or product categories do not have pages as such we need to use their parent page.
		if ($page->slug == 'products' && !empty($parameters['product'])) {
			$page->template->filename = 'product';
		}
		
		if ($page->slug == 'products' && !empty($parameters['productCategory'])) {
			$page->template->filename = 'productCategory';
		}
		
		if ($page->slug == 'products' && !empty($parameters['search'])) {
			$page->template->filename = 'productSearch';
		}
		
		// Since individual articles do not have pages as such we need to use their parent page.
		if ($page->slug == 'articles' && !empty($parameters['article'])) {
			$page->template->filename = 'article';
		}
		
		if ($page->slug == 'manufacturers') {
			$page->template->filename = 'productManufacturers';
		}
		
		// Since individual product manufacturers do not have pages as such we need to use their parent page.
		if ($page->slug == 'manufacturers' && !empty($parameters['productManufacturer'])) {
			$page->template->filename = 'productManufacturer';
		}
		
		// TODO - I WISH THERE WAS A WAY TO DO THIS DYNAMICALLY
		$templates = [
			'cart' => CartTemplate::class,
			'page' => PageTemplate::class,
			'product' => ProductTemplate::class,
			'contact' => ContactTemplate::class,
			'article' => ArticleTemplate::class,
			'checkout' => CheckoutTemplate::class,
			'products' => ProductsTemplate::class,
			'articles' => ArticlesTemplate::class,
			'homepage' => HomepageTemplate::class,
			'productSearch' => ProductSearchTemplate::class,
			'productCategory' => ProductCategoryTemplate::class,
			'productManufacturer' => ProductManufacturerTemplate::class,
			'productManufacturers' => ProductManufacturersTemplate::class,
		];
		
		// If no template setup, fall back to default template.
		if (!$page->template || !isset($templates[$page->template->filename])) {
			$template = app($templates['page']);
		} else {
			$template = app($templates[$page->template->filename]);
		}
		
		$view = sprintf('templates.%s', $template->getView());
		
		if (!view()->exists($view)) {
			abort(500, $view.' does not exist');
		}
		
		$template->prepare($view = view($view), $parameters);
		
		$page->view = $view;
	}
}
