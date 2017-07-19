<?php
	
move_uploaded_file($_FILES['file']['tmp_name'], '/files/'.$_FILES['file']['name']);

$array = array(
    'url' => '/files/'.$_FILES['file']['name'],
    'name' => $_FILES['file']['name']
);

echo stripslashes(json_encode($array));
