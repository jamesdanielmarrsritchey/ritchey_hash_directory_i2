<?php
$location = realpath(dirname(__FILE__));
require_once $location . '/list_files_and_folders_i1_v1.php';
$return = list_files_and_folders_i1_v1("{$location}/temporary", TRUE);
if ($return == TRUE){
	print_r($return);
} else {
	echo "FALSE\n";
}
?>