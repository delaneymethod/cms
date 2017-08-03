<?php

namespace App\Http\Traits;

use App\Models\Page;

trait PageTrait
{
	/**
	 * Get the specified page based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getPage(int $id)
	{
		return Page::find($id);
	}
	
	/**
	 * Get the specified page based on slug.
	 *
	 * @param 	string 		$slug
	 * @return 	Object
	 */
	public function getPageBySlug(string $slug)
	{
		return Page::where('slug', $slug)->where('status_id', 4)->firstOrFail();
	}
	
	/**
	 * Get the specified page based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getPageOrFail(int $id)
	{
		return Page::findOrFail($id);
	}
	
	/**
	 * Get all the pages.
	 *
	 * @return 	Collection
	 */
	public function getPages()
	{
		return Page::all();
	}
	
	/**
	 * Get all the pages in hierarchy.
	 *
	 * @return 	Collection
	 */
	public function getPagesHierarchy()
	{
		return Page::all()->toHierarchy();
	}
	
	/**
	 * Rebuilds (or reindexes) the Tree-structure 
	 *
	 * @return 	bool
	 */
	public function rebuildPages()
	{
		return Page::rebuild(true);
	}
}
