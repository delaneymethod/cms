<?php

namespace App\Http\Traits;

use App\Models\Page;
use App\Models\Article;
use App\Models\Content;
use App\Http\Traits\FieldTrait;

trait ContentTrait
{
	use FieldTrait;
	
	/**
	 * Get the specified content based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getContent(int $id)
	{
		return Content::findOrFail($id);
	}
	
	/**
	 * Get the specified content based on page id.
	 *
	 * @param 	int		$fieldId
	 * @return 	Object
	 */
	public function getContentByField(int $fieldId)
	{
		return Content::where('field_id', $fieldId)->firstOrFail();
	}
	
	/**
	 * Get the specified content for a page.
	 *
	 * @param 	Page		$page
	 * @return 	Object
	 */
	public function getPageContent(Page $page) 
	{
		$contents = $page->contents;
		
		foreach ($contents as $content) {
			$field = $this->getField($content->field_id);
			
			$page[$field->handle] = $content->data;
		}
		
		return $page;
	}
	
	/**
	 * Get the specified content for an article.
	 *
	 * @param 	Article		$article
	 * @return 	Object
	 */
	public function getArticleContent(Article $article) 
	{
		$contents = $article->contents;
		
		foreach ($contents as $content) {
			$field = $this->getField($content->field_id);
			
			$article[$field->handle] = $content->data;
		}
		
		return $article;
	}

	/**
	 * Get all the contents.
	 *
	 * @return 	Response
	 */
	public function getContents()
	{
		return Content::all();
	}
}
