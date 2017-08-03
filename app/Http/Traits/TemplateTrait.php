<?php

namespace App\Http\Traits;

use App\Models\Template;

trait TemplateTrait
{
	/**
	 * Get the specified template based on id.
	 *
	 * @param 	int 		$id
	 * @return 	Object
	 */
	public function getTemplate(int $id)
	{
		return Template::findOrFail($id);
	}
	
	/**
	 * Get the specified template based on filename.
	 *
	 * @param 	string 		$filename
	 * @return 	Object
	 */
	public function getTemplateByFilename(string $filename)
	{
		return Template::where('filename', $filename)->firstOrFail();
	}

	/**
	 * Get all the templates.
	 *
	 * @return 	Response
	 */
	public function getTemplates()
	{
		return Template::all();
	}
}
