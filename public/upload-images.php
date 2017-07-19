<?php
	
$dir = '/images/';

$_FILES['file']['type'] = strtolower($_FILES['file']['type']);

if ($_FILES['file']['type'] == 'image/png' || $_FILES['file']['type'] == 'image/jpg' || $_FILES['file']['type'] == 'image/gif' || $_FILES['file']['type'] == 'image/jpeg' || $_FILES['file']['type'] == 'image/pjpeg') {
   	$filename = md5(date('YmdHis')).'.jpg';
    
    $file = $dir.$filename;

    move_uploaded_file($_FILES['file']['tmp_name'], $file);

    $array = array(
        'url' => 'images/'.$filename,
        'id' => 123
    );

    echo stripslashes(json_encode($array));
}
