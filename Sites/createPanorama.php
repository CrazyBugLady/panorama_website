<?php
	// Schnittstelle, um auch mittels Scripts Bilder zu erstellen

	require_once("../app/includes/config.php");
	require_once("../app/BusinessObjects/Camera.php");
	include_once("../app/PanoramaManager.php");

	$saveTemporarily = true;

	if(array_key_exists($_REQUEST, "saveTemporarily"))
	{
		$saveTemporarily = $_REQUEST["saveTemporarily"];
	}
	
	// von Script übergebene Parameter
	if(isset($_SERVER['argc']) && $_SERVER['argc'] > 1)
	{
		$saveTemporarily = $_SERVER["argv"][1];
	}
	
	PanoramaWebsite\PanoramaManager::createNewPanorama("../".ARCHIVE_DIR, "../".TEMP_DIR, $saveTemporarily);
?>