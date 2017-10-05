<?php
$root = $_SERVER['DOCUMENT_ROOT'];

$directory = urldecode($_REQUEST['directory']);

if (file_exists($root.$directory)) {
	$files = scandir($root.$directory);
	
	natcasesort($files);
	
	if (count($files) > 2) {
		echo '<ul class="browseAssets" style="display: none;">';

		foreach ($files as $file) {
			if (file_exists($root.$directory.$file) && $file != '.DS_Store' && $file != '.' && $file != '..' && is_dir($root.$directory.$file)) {
				echo '<li class="directory collapsed"><a href="javascript:void(0);" rel="'.htmlentities($directory.$file).'/">'.htmlentities($file).'</a></li>';
			}
		}

		foreach ($files as $file) {
			if (file_exists($root.$directory.$file) && $file != '.DS_Store' && $file != '.' && $file != '..' && !is_dir($root.$directory.$file)) {
				$ext = preg_replace('/^.*\./', '', $file);
				
				echo '<li class="file ext_'.$ext.'"><a href="javascript:void(0);" rel="'.htmlentities($directory.$file).'">'.htmlentities($file).'</a></li>';
			}
		}
		
		echo '</ul>';	
	}
}
