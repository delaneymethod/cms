<?php

namespace App\Http\Traits;

use App\Models\{Page, Template};
use Illuminate\Database\Eloquent\Collection as CollectionResponse;
use App\Templates\{CartTemplate, PageTemplate, ContactTemplate, ProductTemplate, ArticleTemplate, CheckoutTemplate, ProductsTemplate, ArticlesTemplate, HomepageTemplate};

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
		// Since individual products or articles do not have pages as such we need to use their parent page.
		if ($page->slug == 'products' && !empty($parameters['product'])) {
			$page->template->filename = 'product';
		}
		
		if ($page->slug == 'articles' && !empty($parameters['article'])) {
			$page->template->filename = 'article';
		}
		
		// TODO - I WISH THERE WAS A WAY TO DO THIS DYNAMICALLY
		$templates = [
			'cart' => CartTemplate::class,
			'page' => PageTemplate::class,
			'contact' => ContactTemplate::class,
			'product' => ProductTemplate::class,
			'article' => ArticleTemplate::class,
			'checkout' => CheckoutTemplate::class,
			'products' => ProductsTemplate::class,
			'articles' => ArticlesTemplate::class,
			'homepage' => HomepageTemplate::class,
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
