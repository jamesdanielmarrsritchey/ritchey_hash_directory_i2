<?php
#Name:List Files And Folders i1 v1
#Content:
if (function_exists('list_files_and_folders_i1_v1') === FALSE){
function list_files_and_folders_i1_v1($source, $display_errors = NULL){
	$errors = array();
	if (@is_dir($source) === FALSE) {
		$errors[] = 'source';
	}
	if ($display_errors === NULL){
		$display_errors = FALSE;
	} else if ($display_errors === TRUE){
		#Do Nothing
	} else if ($display_errors === FALSE){
		#Do Nothing
	} else {
		$errors[] = "display_errors";
	}
	##Task []
	if (@empty($errors) === TRUE){
		$files = array();
		$directories = array("$source");
		$files_and_directories = array();
		do {
			$handle = @opendir("$directories[0]");
			if ($handle !== FALSE){
				$entry = TRUE;
				do {
					$entry = readdir($handle);
					if (@is_dir("{$directories[0]}/{$entry}") === TRUE AND "$entry" !== "." AND "$entry" !== ".." AND "$entry" !== ""){
						@array_push($directories, "{$directories[0]}/{$entry}");
						$files_and_directories[] = "{$directories[0]}/{$entry}";
					} else if (@is_file("{$directories[0]}/{$entry}") === TRUE){
						$files[] = "{$directories[0]}/{$entry}";
						$files_and_directories[] = "{$directories[0]}/{$entry}";
					}
				} while ($entry !== FALSE);
			}
			@closedir();
			unset($directories[0]);
			$directories = @array_values($directories);
		} while (@"$directories[0]" == TRUE);
	}
	result:
	##Display Errors
	if ($display_errors === TRUE){
		if (@empty($errors) === FALSE){
			$message = @implode(", ", $errors);
			if (function_exists('list_files_and_folders_i1_v1_format_error') === FALSE){
				function list_files_and_folders_i1_v1_format_error($errno, $errstr){
					echo $errstr;
				}
			}
			set_error_handler("list_files_and_folders_i1_v1_format_error");
			trigger_error($message, E_USER_ERROR);
		}
	}
	##Return
	if (@empty($errors) === TRUE){
		return $files_and_directories;
	} else {
		return FALSE;
	}
}
}
?>