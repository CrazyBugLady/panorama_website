$(document).ready(function(){
	
	refreshTempImg();
	
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
		if($("#archiveFolder").val() === "---")
		{
			$("#archiveFolderTwo").hide();
			$("#ArchiveImages").hide();
		}	
		else
		{
			getMoreFolders($("#archiveFolder").val());	
		}
	});
	
	// Eventhandler für das Select archiveFolderTwo
	$("#archiveFolderTwo").change(function(){
		if($("#archiveFolderTwo").val() === "---")
		{
			$("#ArchiveImages").hide();
		}	
		else
		{
			getImages($("#archiveFolder").val() + "/" + $("#archiveFolderTwo").val())
		}
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
			$("#panoramaActions").html("Bild erfolgreich erstellt");
			$("#panoramaActions").addClass("alert alert-success");
			refreshTempImg();
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
			$("#panoramaActions").html("Bilder gelöscht!");
			$("#panoramaActions").addClass("alert alert-success");
			refreshTempImg();
		});
	}
	
	// Funktion, die das aktuelle temporär gespeicherte Bild refresht, um zu prüfen, ob es sich unterdessen geändert hat
	function refreshTempImg()
	{
		var d = new Date();
		var day = d.getDay() + "." + d.getMonth() + "." + d.getFullYear();
		var time = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
		
		$("#tempimg").attr("src", "http://localhost/panorama_website/Resources/Images/Temp/temp.jpg"); // force the application to reload
		$("#timeInformationImage").html("Zuletzt aktualisiert am " + day + " um " + time);
	}
	
	// Jede Minute wird das Bild neu gesetzt, um zu überprüfen, ob es sich unterdessen geändert hat
	setTimeout(function() {
      refreshTempImg();
	}, 60000);
	
	// Funktion um Ordner und Unterordner im Archiv zu erhalten
	function getMoreFolders(path)
	{
		$("#archiveFolderTwo").show().fadeIn();
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
		$("#ArchiveImages").show().fadeIn();
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