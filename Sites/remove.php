<?php

/**
 * @brief Ermöglich rekursives Löschen von Ordnern und Dateien - von verschiedenen Iterationen in den Kommentaren von http://ch2.php.net/manual/en/function.rmdir.php übernommen
 * 
 * @param String $dir Pfadname zum zu löschenden Ordner
 * @return bool
 */
function delTree($dir) {
   $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
  }
  
  set_time_limit(0);
  
  $olddate = date("d.m.Y", mktime(0,0,0, date("m"), date("d")-14, date("Y")));

  if(file_exists("images/".$olddate))
    delTree("images/".$olddate);
  
  
?>