<?php
	include_once("app/includes/config.php");
	require_once("app/BusinessObjects/Camera.php");
	include_once("app/PanoramaManager.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Panorama Website</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="assets/css/theme.css" rel="stylesheet">
  </head>

  <body role="document">

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Panorama Photography Website</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if(array_key_exists("site", $_GET) == false || $_GET["site"] != "archive") { echo "class='active'"; }  ?>><a href="index.php">Home</a></li>
            <li <?php if(array_key_exists("site", $_GET) && $_GET["site"] == "archive") { echo "class='active'"; }  ?>><a href="?site=archive">Archive</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container theme-showcase" role="main">

      <div class="jumbotron">
        <h1>Aktuell</h1>
        <p><?php echo PanoramaWebsite\PanoramaManager::getCurrentTempImage(TEMP_DIR . "/" . TEMP_NAME, 1000, 300); ?></p>
		<p id="timeInformationImage"></p>
		<p><button id="makePanorama" class="btn btn-primary">Panoramaaufnahme starten</button> 
		<button id="removePanorama" class="btn btn-danger">Bilder älter als 14 Tage löschen</button></p>
		<p id="panoramaActions"></p>
      </div>
	
	<?php
		if(array_key_exists("site", $_GET) && $_GET["site"] == "archive"){
			include_once(SITES_DIR . "/archiv.php");
		}
	?>

	 </div>
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
  </body>
</html>