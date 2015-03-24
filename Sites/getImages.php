<?php
	require_once("../app/includes/config.php");
	require_once("../app/BusinessObjects/Camera.php");
	include_once("../app/PanoramaManager.php");
	
	$folder = "";
	
	if(array_key_exists("folder", $_REQUEST))
	{
		$folder = $_REQUEST["folder"];
	}
	
	echo json_encode(PanoramaWebsite\PanoramaManager::getImagesForFolder("../".ARCHIVE_DIR . "/", $folder));
  
?>