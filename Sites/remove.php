<?php
	require_once("../app/includes/config.php");
	require_once("../app/BusinessObjects/Camera.php");
	include_once("../app/PanoramaManager.php");

	$days = 14;
	
	if(array_key_exists($_POST, "days"))
	{
		$days = $_POST["days"];
	}
	
	PanoramaWebsite\PanoramaManager::removePanoramas($days, "../".ARCHIVE_DIR);
  
?>