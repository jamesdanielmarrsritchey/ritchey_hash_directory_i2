<?php
# Meta
// Name: Ritchey Hash Directory i2 v1
// Description: Returns a string on success. Returns "FALSE" on failure.
// Notes: Optional arguments can be "NULL" to skip them in which case they will use default values.
// Arguments: Source Folder (required) is the folder to copy files from. Hashing Algorithim (optional) specifies the hashing algorithm to use. Include Structure (optional) specifies if the paths of files should be included in the hashing. Relative Structure (optional) specifies if the structure paths should be trimmed relative to the source_folder when being hashed. Display Errors (optional) specifies if errors should be displayed after the function runs.
// Arguments (For Machines): source_folder: path, required. hashing_algorithm: string, optional. include_structure: bool, optional. relative_structure: bool, optional. display_errors: bool, optional.
# Content
if (function_exists('ritchey_hash_directory_i2_v1') === FALSE){
function ritchey_hash_directory_i2_v1($source_folder, $hashing_algorithm = NULL, $include_structure = NULL, $relative_structure = NULL, $display_errors = NULL){
	## Prep
	$errors = array();
	$location = realpath(dirname(__FILE__));
	if (@is_dir($source_folder) === FALSE){
		$errors[] = "source_folder";
	}
	if ($hashing_algorithm === NULL){
		$hashing_algorithm = 'sha3-256';
	} else if ($hashing_algorithm === 'sha3-256'){
		// Do nothing
	} else if ($hashing_algorithm === 'sha256'){
		// Do nothing
	} else if ($hashing_algorithm === 'sha1'){
		// Do nothing
	} else if ($hashing_algorithm === 'md5'){
		// Do nothing
	} else if ($hashing_algorithm === 'crc32'){
		// Do nothing
	} else {
		$errors[] = "hashing_algorithm";
	}
	if ($include_structure === NULL){
		$include_structure = TRUE;
	} else if ($include_structure === TRUE){
		// Do nothing
	} else if ($include_structure === FALSE){
		// Do nothing
	} else {
		$errors[] = "include_structure";
	}
	if ($relative_structure === NULL){
		$relative_structure = TRUE;
	} else if ($relative_structure === TRUE){
		// Do nothing
	} else if ($relative_structure === FALSE){
		// Do nothing
	} else {
		$errors[] = "relative_structure";
	}
	if ($display_errors === NULL){
		$display_errors = TRUE;
	} else if ($display_errors === TRUE){
		// Do nothing
	} else if ($display_errors === FALSE){
		// Do nothing
	} else {
		$errors[] = "display_errors";
	}
	## Task
	if (@empty($errors) === TRUE){
		### Create a list of files in source_folder, hash all the files, sort the files by checksum, hash the file paths as the first part of the input, re-hash all the file data as a the remainder of the input, and return the checksum.
		$results = '';
		$location = realpath(dirname(__FILE__));
		require_once $location . '/custom_dependencies/list_files_and_folders_i1_v1/list_files_and_folders_i1_v1.php';
		$files_and_folders = list_files_and_folders_i1_v1($source_folder, TRUE);
		sort($files_and_folders, SORT_REGULAR);
		$files = array();
		foreach($files_and_folders as $value){
			if (is_file($value) === TRUE){
				$checksum = hash_file($hashing_algorithm, $value);
				$files[$checksum] = $value;
			}
		}
		ksort($files, SORT_REGULAR);
		$relative_files_and_folders = $files_and_folders;
		foreach($relative_files_and_folders as &$value){
			$length = strlen($source_folder);
			if (substr($value, 0, $length) === $source_folder){
				$value = substr($value, $length);
			}
		}
		unset($value);
		$hash_work = hash_init($hashing_algorithm);
		if ($include_structure === TRUE){
			if ($relative_structure === TRUE){
				hash_update($hash_work, implode($relative_files_and_folders));
			} else {
				hash_update($hash_work, implode($files_and_folders));
			}
		}
		foreach($files as &$item){
			$handle = fopen($item, 'rb');
			hash_update_stream($hash_work, $handle);
			fclose($handle);
		}
		unset($item);
		$results = hash_final($hash_work);
	}
	//echo "Memory Usage: " . memory_get_usage() . " bytes" . PHP_EOL;
	cleanup:
	## Cleanup
		// Do nothing
	result:
	## Display Errors
	if ($display_errors === TRUE){
		if (@empty($errors) === FALSE){
			$message = @implode(", ", $errors);
			if (function_exists('ritchey_hash_directory_i2_v1_format_error') === FALSE){
				function ritchey_hash_directory_i2_v1_format_error($errno, $errstr){
					echo $errstr;
				}
			}
			set_error_handler("ritchey_hash_directory_i2_v1_format_error");
			trigger_error($message, E_USER_ERROR);
		}
	}
	## Return
	if (@empty($errors) === TRUE){
		return $results;
	} else {
		return FALSE;
	}
}
}
?>