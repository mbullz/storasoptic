<?php
$file_to_zip = "";
if ($handle = opendir('.')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $file_to_zip .= "'".$entry;
			if(is_dir($entry)) {
				$file_to_zip .="/'";	
			}else{
				$file_to_zip .="'";
			}
			$file_to_zip .=",";
        }
    }
    closedir($handle);
}
$file_to_zip .=",";
$file_to_zip = str_replace(",,","",$file_to_zip);
// ---
/* creates a compressed zip file */
function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}
// ---
//echo $file_to_zip;
$result = create_zip('component/','backup/my-archive.zip');
if($result) { echo "OK";}else{ echo "FAILED"; }
?>