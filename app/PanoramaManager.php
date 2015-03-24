<?php
	namespace PanoramaWebsite;
	
	/*
	* Klasse, die dafür zuständig ist, alle Interaktionen mit Panoramafunktionen zu managen
	*/
	class PanoramaManager{
		
		/*
		* Funktion um alle Archivordner zu erhalten
		*/
		public static function getArchiveFolders($PathArchive){
			$archiveLinks = array();
		
			$ArchiveFolders = opendir($PathArchive);
			while(false !== ($ArchiveFolderTemp = readdir($ArchiveFolders))) {
				if(is_dir($PathArchive . "/" . $ArchiveFolderTemp) && $ArchiveFolderTemp != "." && $ArchiveFolderTemp != "..") {
					array_push($archiveLinks, $ArchiveFolderTemp);
				}
			}
			
			return $archiveLinks;
		}
		
		/*
		* Funktion, um alle, innerhalb eines Ordners vorhandenen Bilder zu erhalten.
		*/
		public static function getImagesForFolder($ArchivePath, $Folder){
			$imageLinks = array();
			
			$ArchiveFolderContent = opendir($ArchivePath ."/". $Folder);
			
			while(false !== ($tempContent = readdir($ArchiveFolderContent))) {
				if(is_dir($ArchivePath . "/" . $Folder . "/" . $tempContent) == false && $tempContent != "." && $tempContent != "..") {
					array_push($imageLinks, $tempContent);
				}
			}
			
			return $imageLinks;
		}
		
		/**
		* Funktion, um das zuletzt erstellte Bild zu erhalten
		*/
		public static function getCurrentTempImage($filepath, $width, $height) {
			print '<a href="'.$filepath.'">
						<img id="tempimg" src="'.$filepath.'" width="'.$width.'" height="'.$height.'" />
				   </a>'; 
		}
		
		/**
		* Funktion, um ein neues Panoramabild zu erstellen
		*/
		public static function createNewPanorama($ArchivePath, $TempPath, $saveTemporarily)
		{
			set_time_limit(0);
			
			\PanoramaWebsite\BusinessObjects\Camera::startPanorama($ArchivePath, $TempPath, $saveTemporarily);
		}
		
		/*
		* Funktion, um die Panorama Bilder, die älter als eine gewisse Anzahl Tage sind, zu löschen
		*/
		public static function removePanoramas($days, $ArchivePath, $folderInFolder = false)
		{
			// Folder und Files innerhalb des Hauptfolders müssen ebenfalls gelöscht werden können, dafür  gibt es eine Option, die dies zulässt, der neue Name wird generiert
			$rootDirectory = $ArchivePath;
			if($folderInFolder == false) {
				$FolderToDelete = date("d.m.Y", mktime(0,0,0, date("m"), date("d")-$days, date("Y")));
				$rootDirectory .= "/" . $FolderToDelete;
			}

			if(file_exists($rootDirectory)){
		
				$files = array_diff(scandir($rootDirectory), array('.','..'));
				foreach ($files as $file) {
					(is_dir($rootDirectory."/".$file)) ? self::removePanoramas(0, $rootDirectory."/".$file, true) : unlink($rootDirectory."/".$file);
				}
				return rmdir($rootDirectory);
			}
			
			return true;
		}
		
	}
?>