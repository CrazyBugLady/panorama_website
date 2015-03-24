<?php 
	namespace PanoramaWebsite\BusinessObjects;
	
	define ('LEFT', 'http://10.142.126.210/cgi-bin/camctrl.cgi?move=left');
	define ('RIGHT', 'http://10.142.126.210/cgi-bin/camctrl.cgi?move=right');
	define ('HOME', 'http://10.142.126.210/cgi-bin/camctrl.cgi?move=home');
	define ('CUR_PIC', 'http://10.142.126.210/cgi-bin/video.jpg');
	define ('IMGNR', 4);          //Anzahl gemachter Bilder
	define ('CUTVAL', 20);        //Pixel welche für einen verbesserten Panoramaeffekt abgeschnitten werden
	
	/*
	* Klasse, die dafür zuständig ist, die Interaktion mit der Kamera zu koordinieren
	*/
	class Camera{
		
		/*
		* Funktion zur Bewegung der Kamera
		*/
		public static function move($times, $direction)
		{
			for ($time = 1; $time <= $times; $time++) {
				file_get_contents($direction);
			}
		}
		
		/*
		* Funktion zur Erstellung und Speicherung des Bildes
		*/
		public static function savePicture($ArchivePath, $TempPath, $savePictureTemporarily)
		{
			$size = getimagesize($TempPath."/img0.jpg");
			$baseimg = imagecreatetruecolor($size[0] * IMGNR - (IMGNR*CUTVAL), $size[1]);
			for ($i=0; $i < IMGNR; $i++) {
				$img = imagecreatefromjpeg($TempPath."/img".$i.".jpg"); 
				imagecopy($baseimg, $img, ($size[0]-CUTVAL)*$i, 0, CUTVAL, 0, $size[0]-CUTVAL
				, $size[1]);
				imagedestroy($img);
			}
                
			$curdate = date("d.m.Y-H-i");
			$filename = explode("-",$curdate);
                
            if(!file_exists($ArchivePath ."/".$filename[0]) && $savePictureTemporarily == false) {
                  mkdir($ArchivePath ."/".$filename[0]);
            }
			
            if(!file_exists($ArchivePath ."/".$filename[0]."/".$filename[1]) && $savePictureTemporarily == false) {
                  mkdir($ArchivePath ."/".$filename[0]."/".$filename[1]);
            }                        
            
            if($saveTemporarily == false) // soll nur temporär gespeichert werden
			{
				imagejpeg($baseimg, $ArchivePath ."/".$filename[0]."/".$filename[1]."/".$filename[2].".jpg"); // Folder for Hour and Folder for Minute
            }
			imagejpeg($baseimg, $TempPath ."/temp.jpg");
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
			self::move(LEFT, 0);
			sleep(5);
			
			self::takePicture(0, $TempPath);
			
			self::move(RIGHT, 0);
			sleep(2);
			
			self::takePicture(1, $TempPath);
			
			self::move(RIGHT, 0);
			sleep(2);
			
			self::takePicture(2, $TempPath);
			
			self::move(RIGHT, -5);
			sleep(2);
			
			self::takePicture(3, $TempPath);
			
			self::savePicture($ArchivePath, $TempPath, $saveTemporarily);
			
			self::move(HOME, -5);
		}
	}
?>