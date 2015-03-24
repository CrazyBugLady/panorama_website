<?php
	// Schnittstelle, um auch über Scripts Bilder zu löschen
	
	require_once("../app/includes/config.php");
	require_once("../app/BusinessObjects/Camera.php");
	include_once("../app/PanoramaManager.php");

	$days = 14;
	
	if(array_key_exists($_REQUEST, "days"))
	{
		$days = $_REQUEST["days"];
	}
	
	// Parameter, die von Script übergeben wurden
	if(isset($_SERVER['argc']) && $_SERVER['argc'] > 1)
	{
		$days = $_SERVER["argv"][1];
	}

		PanoramaWebsite\PanoramaManager::removePanoramas($days, "../".ARCHIVE_DIR);
?>