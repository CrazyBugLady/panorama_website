$(document).ready(function(){
	
	// Eventhandler für den Button makePanorama
	$("#makePanorama").click(function(){
		createPanorama();
	});
	
	// Eventhandler für den Button removePanorama
	$("#removePanorama").click(function(){
		removePanorama();
	});
	
	$("#archiveFolder").change(function(){
		getMoreFolders();
	});
	
	// Funktion, die ein Panoramabild erstellen soll
	function createPanorama()
	{
		$.ajax({
			method: "POST",
			url: "http://localhost/panorama_website/Sites/createPanorama.php",
			data: { saveTemporarily: "true" }
		})
		.done(function( msg ) {
			$("#tempimg").attr("src", "http://localhost/panorama_website/Resources/Images/Temp/temp.jpg"); // force the application to reload
		});
	}
	
	
	// Funktion, um ein Ajax Request an eine Datei zu schicken, die alle Bilder, die älter als 14 Tage sind, entfernen soll
	function removePanorama()
	{
		$.ajax({
			method: "POST",
			url: "http://localhost/panorama_website/Sites/remove.php",
			data: { days: "14" }
		})
		.done(function( msg ) {
			$("#tempimg").attr("src", "http://localhost/panorama_website/Resources/Images/Temp/temp.jpg"); // force the application to reload
		});
	}
	
	function getMoreFolders()
	{
		
	}
});