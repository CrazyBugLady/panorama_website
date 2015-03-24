<?php
	require_once("./app/includes/config.php");
	require_once("./app/BusinessObjects/Camera.php");
	include_once("./app/PanoramaManager.php");
	
	$path = "";
	
	if(array_key_exists($_POST, "path")
	{
		$path = $_POST["path"];
	}
	
	echo json_encode(PanoramaWebsite\PanoramaManager::getArchiveFolders("./".ARCHIVE_DIR."/".));
  
?>