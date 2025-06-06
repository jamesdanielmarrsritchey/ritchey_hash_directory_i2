<?php
# App.php
$location = realpath(dirname(__FILE__));
require_once $location . '/ritchey_hash_directory_i2_v2.php';
$return = ritchey_hash_directory_i2_v2("{$location}/temporary/Example 1", 'sha3-256', TRUE, TRUE, NULL);
if (@is_string($return) === TRUE){
	echo $return . PHP_EOL;
} else {
	echo "FALSE" . PHP_EOL;
}
?>