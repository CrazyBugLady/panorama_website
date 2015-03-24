<?php
	require_once("./app/includes/config.php");
	require_once("./app/BusinessObjects/Camera.php");
	include_once("./app/PanoramaManager.php");

	$saveTemporarily = true;

	if(array_key_exists($_POST, "saveTemporarily"))
	{
		$saveTemporarily = $_POST["saveTemporarily"];
	}
	
	PanoramaWebsite\PanoramaManager::createNewPanorama("./".ARCHIVE_DIR, "./".TEMP_DIR, $saveTemporarily);
?>