<?php
	$archiveFolders = PanoramaWebsite\PanoramaManager::getArchiveFolders(ARCHIVE_DIR);
	?>
	
		<h1>Archiv</h1>
	
		<div class="form-group">
			<label for="archiveFolder">Datum</label>
			<select id="archiveFolder" class="form-control">
				<option>---</option>
				<?php
					foreach($archiveFolders as $folder){
				?>
						<option><?php echo $folder; ?></option>
				<?php
					}
				?>
			</select>
		</div>
		
		<div class="form-group">
			<label for="archiveFolderTwo">Stunde</label>
			<select id="archiveFolderTwo" class="form-control">
			</select>
		</div>
		<hr>
		<div id="ArchiveImages">
			
		</div>