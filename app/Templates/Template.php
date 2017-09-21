<?php
/**
 * @link      https://www.delaneymethod.com/cms
 * @copyright Copyright (c) DelaneyMethod
 * @license   https://www.delaneymethod.com/cms/license
 */
	
namespace App\Templates;

use Illuminate\View\View;

abstract class Template
{
	protected $view;
	
	abstract public function prepare(View $view, array $parameters);
	
	public function getView() : string
	{
		return $this->view;
	}
}
