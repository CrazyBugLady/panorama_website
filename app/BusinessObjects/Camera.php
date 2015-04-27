<?php 
	namespace PanoramaWebsite\BusinessObjects;
	
	define ('LEFT', 'http://192.168.1.115/cgi-bin/camctrl.cgi?move=left');
	define ('RIGHT', 'http://192.168.1.115/cgi-bin/camctrl.cgi?move=right');
	define ('HOME', 'http://192.168.1.115/cgi-bin/camctrl.cgi?move=home');
	define ('CUR_PIC', 'http://192.168.1.115/cgi-bin/video.jpg');
	define ('IMGNR', 3);          //Anzahl gemachter Bilder
	define ('CUTVAL', 0);        //Pixel welche für einen verbesserten Panoramaeffekt abgeschnitten werden
	
	/*
	* Klasse, die dafür zuständig ist, die Interaktion mit der Kamera zu koordinieren
	*/
	class Camera{
		
		/*
		* Funktion zur Bewegung der Kamera
		*/
		public static function move($direction, $times, $speedpan = 5)
		{
			for ($time = 1; $time <= $times; $time++) {
				file_get_contents($direction . '&speedpan=' . $speedpan);
			}
		}
		
		/*
		* Funktion zur Erstellung und Speicherung des Bildes
		*/
		public static function savePicture($ArchivePath, $TempPath, $savePictureTemporarily)
		{
			$tempPanorama = imagecreatetruecolor(1920, 480);
			$size = getimagesize($TempPath."/img0.jpg");
			//$baseimg = imagecreatetruecolor($size[0] * IMGNR - (IMGNR*CUTVAL), $size[1]);
			for ($i=0; $i < IMGNR; $i++) {
				$img = imagecreatefromjpeg($TempPath."/img".$i.".jpg"); 
				//imagecopy($baseimg, $img, ($size[0]-CUTVAL)*$i, 0, CUTVAL, 0, $size[0]-CUTVAL
				//, $size[1]);
				if(CUTVAL > 0) {
					imagecopy($tempPanorama, $img, ($size[0]-CUTVAL)*$i, 0, 0, 0, $size[0]-CUTVAL, $size[1]);
				}
				else
				{
					imagecopy($tempPanorama, $img, $size[0]*$i, 0, 0, 0, $size[0], $size[1]);
				}
				
				imagedestroy($img);
			}
            
			$panoramaFull = imagecreatetruecolor(1920, 461);
			imagecopy($panoramaFull, $tempPanorama, 0, 0, 0, 14, 1920, 461);			
				
			$curdate = date("d.m.Y-H-i");
			$filename = explode("-",$curdate);
                
            if(!file_exists($ArchivePath ."/".$filename[0]) && $savePictureTemporarily == false) {
                  mkdir($ArchivePath ."/".$filename[0]);
            }
			
            if(!file_exists($ArchivePath ."/".$filename[0]."/".$filename[1]) && $savePictureTemporarily == false) {
                  mkdir($ArchivePath ."/".$filename[0]."/".$filename[1]);
            }                        
            
            if($savePictureTemporarily == false) // soll nur temporär gespeichert werden
			{
				imagejpeg($panoramaFull, $ArchivePath ."/".$filename[0]."/".$filename[1]."/".$filename[2].".jpg"); // Folder for Hour and Folder for Minute
            }
			imagejpeg($panoramaFull, $TempPath ."/temp.jpg");
		}
				
		/*
		* Funktion, um das aktuelle Bild, das gemacht wurde, zu speichern
		*/
		public static function takePicture($indexP, $TempPath)
		{
			file_put_contents($TempPath . "/img".$indexP.".jpg", fopen(CUR_PIC, 'r'));   
		}
		
		/*
		* Funktion, um die Erstellung des Panoramas von vorne bis hinten durchzuführen
		*/
		public static function startPanorama($ArchivePath, $TempPath, $saveTemporarily)
		{
			self::move(HOME, 1, 5);
			sleep(2);
			
			self::takePicture(0, $TempPath);
			
			self::move(RIGHT, 2, -5);
			self::move(RIGHT, 3, 0);
			
			sleep(3);
			
			self::takePicture(1, $TempPath);
			
			sleep(3);
		
			self::move(RIGHT, 2, -5);
			self::move(RIGHT, 3, 0);
			
			sleep(3);
			
			self::takePicture(2, $TempPath);
			
			self::savePicture($ArchivePath, $TempPath, $saveTemporarily);

		}
	}
?>