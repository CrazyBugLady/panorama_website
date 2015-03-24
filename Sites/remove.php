<?php
	// Schnittstelle, um auch über Scripts Bilder zu löschen
	
	require_once("../app/includes/config.php");
	require_once("../app/BusinessObjects/Camera.php");
	include_once("../app/PanoramaManager.php");

	// Option um einzustellen, wie viele Tage vorher die Einträge gelöscht werden sollen
	$days = 14;
	
	if(array_key_exists("days", $_REQUEST))
	{
		$days = $_REQUEST["days"];
	}
	
	// Parameter, die von Script übergeben wurden
	if(isset($_SERVER['argc']) && $_SERVER['argc'] > 1)
	{
		$days = $_SERVER["argv"][1];
	}

	$ArchivePath ="../".ARCHIVE_DIR; 
	
	PanoramaWebsite\PanoramaManager::removePanoramas($days, $ArchivePath);
?>