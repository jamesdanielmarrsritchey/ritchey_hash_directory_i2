<?php
# App.php
$location = realpath(dirname(__FILE__));
require_once $location . '/ritchey_hash_directory_i2_v1.php';
$return = ritchey_hash_directory_i2_v1("{$location}/temporary/Example 1", 'md5', TRUE, TRUE, NULL);
if (@is_string($return) === TRUE){
	echo $return . PHP_EOL;
} else {
	echo "FALSE" . PHP_EOL;
}
?>