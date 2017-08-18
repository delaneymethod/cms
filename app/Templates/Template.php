<?php
namespace App\Templates;

use Illuminate\View\View;

abstract class Template
{
	protected $view;
	
	abstract public function prepare(View $view, array $parameters);
	
	public function getView()
	{
		return $this->view;
	}
}
