<?php

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
|
| This file is where you may define all of the helpers that are handled
| by your application.
|
*/

if (!function_exists('setActive')) {
	/**
	 * Checks the path against the request path and return true or false.
	 *
	 * @return string
	 */
	function setActive($path)
	{
		return request()->is($path.'*') ? 'active' : '';
	}
}

if (!function_exists('setClass')) {
	/**
	 * Checks the path against the request path and return true or false.
	 *
	 * @return string
	 */
	function setClass($path, $class)
	{
		return request()->is($path.'*') ? $class : '';
	}
}

if (!function_exists('currentYear')) {
	/**
	 * Gets the current year
	 *
	 * @return integer
	 */
	function currentYear()
	{
		return date('Y');
	}
}

if (!function_exists('slugToTitle')) {
	/**
	 * Creates a title based on slug
	 */
	function slugToTitle($string)
	{
    	$string = str_replace(array('_', '-'), array(' '), $string);
		
		$string = ucwords($string);
		
		return $string;
	}
}

if (!function_exists('flash')) {
	/**
	 * Creates new session flash message
	 */
	function flash($message, $level = 'info')
	{
		session()->flash('status', $message);

		$levels = ['success', 'info', 'warning', 'danger'];

		// Do a quick check to make sure we're only setting available classes from Bootstrap.
		if (in_array($level, $levels)) {
			session()->flash('status_level', $level);
		} else {
			session()->flash('status_level', 'info');
		}
	}
}
