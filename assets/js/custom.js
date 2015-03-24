$(document).ready(function(){
	
	// Eventhandler für den Button makePanorama
	$("#makePanorama").click(function(){
		createPanorama();
	});
	
	// Eventhandler für den Button removePanorama
	$("#removePanorama").click(function(){
		removePanorama();
	});
	
	// Eventhandler für das Select archiveFolder
	$("#archiveFolder").change(function(){
		getMoreFolders($("#archiveFolder").val());	
	});
	
	// Eventhandler für das Select archiveFolderTwo
	$("#archiveFolderTwo").change(function(){
		getImages($("#archiveFolder").val() + "/" + $("#archiveFolderTwo").val())
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
			data: { days: 14 }
		})
		.done(function( msg ) {
			$("#tempimg").attr("src", "http://localhost/panorama_website/Resources/Images/Temp/temp.jpg"); // force the application to reload
		});
	}
	
	// Timeout to refresh the image every now and then
	setTimeout(function() {
      $("#tempimg").attr("src", "http://localhost/panorama_website/Resources/Images/Temp/temp.jpg"); // force the application to reload
	  $("#timeInformationImage").clear();
	  $("#timeInformationImage").html("Zuletzt aktualisiert um " + $.now());
	}, 5000);
	
	// Funktion um Ordner und Unterordner im Archiv zu erhalten
	function getMoreFolders(path)
	{
		$.ajax('http://localhost/panorama_website/Sites/getFolders.php', {
				dataType: 'json',
				data:	{ 
					path: path
				},
				success: function(data) {
					$("#archiveFolderTwo").empty()
						$("#archiveFolderTwo").append("<option>---</option>");
					$.each(data, function(index, item) {
						$("#archiveFolderTwo").append('<option>' + item +'</option>');
					});
					
						$("#archiveFolderTwo").stop();//.fadeIn();
			
				},
			
				error: function(xhr, status, error) {
				}
			});
	}
	
	// Funktion um die Bilder für den aktuell ausgewählten Ordner zu erhalten
	function getImages(folder)
	{
		$.ajax('http://localhost/panorama_website/Sites/getImages.php', {
				dataType: 'json',
				data:	{ 
					folder: folder
				},
				success: function(data) {
					var date = $("#archiveFolder").val();
					var hour = $("#archiveFolderTwo").val();
					$("#ArchiveImages").empty()
					$.each(data, function(index, item) {
						var minute = item.split('.');
						$("#ArchiveImages").append('<img src="http://localhost/panorama_website/Resources/Images/Archive/' + folder + "/" + item +'" class="img-thumbnail">');
						$("#ArchiveImages").append('<div class="alert alert-info" role="alert">Bild wurde am ' + date + ' um ' + hour + ':'+ minute[0] +' erstellt</div>');
					});
					
						$("#ArchiveImages").stop();//.fadeIn();
			
				},
			
				error: function(xhr, status, error) {
				}
			});
	}
});