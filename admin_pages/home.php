<center>
	<label class="title_genotate" href='./'>Genotate</label>
	<br>
	<label style='font-size: 20px;' href='./'>
		automatic annotation and research
		<br>
		platform for transcripts
	</label>
</center>
<br>
<p style='font-size: 16px; text-align: justify; text-justify: inter-word;'>Genotate platform is a web-based interactive environment to automatically identify, search and visualize functional annotations and similarity annotations for assembled transcripts. The aim is to provide to bioinformaticians,
	systems biologists, and experimental biologists a way to gather transcriptomic information obtained from various predictive algorithms for a given set of transcripts.</p>
<br>
<style>
.btn {
	width: 100%;
	height: 100%;
	font-size: 14px;
	font-family: Helvetica, Arial, Sans-Serif;
	color: lightgrey;
	background-color: #24292e;
	word-break: break-all;
}

.btn:hover img {
	-webkit-filter: invert(100%) !important;
}

.header_genotate:hover {
	color: white;
}
</style>

<?php
$file_paths = array ();
$genotate_dir = dirname ( dirname ( __DIR__ ) );
$file_path = $genotate_dir . "/binaries";
array_push ( $file_paths, $file_path );
$file_path = $genotate_dir . "/binaries/genotate.jar";
array_push ( $file_paths, $file_path );
$file_path = $genotate_dir . "/binaries/genotate.config";
array_push ( $file_paths, $file_path );
$file_path = $genotate_dir . "/tmp";
array_push ( $file_paths, $file_path );
$file_path = $genotate_dir . "/services";
array_push ( $file_paths, $file_path );
$file_path = $genotate_dir . "/services/java/bin/java";
array_push ( $file_paths, $file_path );
$file_path = $genotate_dir . "/workspace";
array_push ( $file_paths, $file_path );
$file_path = $genotate_dir . "/workspace/config";
array_push ( $file_paths, $file_path );
$file_path = $genotate_dir . "/workspace/blastdb";
array_push ( $file_paths, $file_path );
$file_path = $genotate_dir . "/workspace/storage";
array_push ( $file_paths, $file_path );
foreach ( $file_paths as $file_path ) {
	if (! file_exists ( $file_path )) {
		$connexion = - 1;
	} else {
		$fileowner = posix_getpwuid ( fileowner ( $file_path ) ) ['name'];
		if (strcmp ( $fileowner, "www-data" ) !== 0) {
			$connexion = - 1;
		}
	}
}
?>


<div class="div-border-title" style='width: 100%;'>Genotate platform functionalities</div>
<div class="div-border" style='width: 100%;'>
	<div style='width: 100%; margin-top: 2px;'>
		<div style='min-width: 209px; width:25%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home5']; ?>">
			<a href="index.php?page=manage_services" class='btn btn-primary'> <img src="/img/database.svg" style='height: 30px; filter: invert(90%);'> <br> <br> Manage functional annotation services
			</a>
		</div>
		<div style='min-width: 209px; width:25%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home6']; ?>">
			<a href="index.php?page=manage_references" class='btn btn-primary'> <img src="/img/database.svg" style='height: 30px; filter: invert(90%);'> <br> <br> Manage references
			</a>
		</div>
		<div style='min-width: 209px; width:25%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home7']; ?>">
			<a href="index.php?page=create_reference" class='btn btn-primary'> <img src="/img/upload.svg" style='height: 30px; filter: invert(90%);'> <br> <br> Create reference
			</a>
		</div>
		<div style='min-width: 209px; width:25%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home8']; ?>">
			<a href="index.php?page=external_references" class='btn btn-primary'> <img src="/img/sync.svg" style='height: 30px; filter: invert(90%);'> <br> <br> External references
			</a>
		</div>
		<div style='min-width: 209px;width:25%; padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home9']; ?>">
			<a href="index.php?page=annotation_colors" class='btn btn-primary'> <img src="/img/config.svg" style='height: 30px; filter: invert(90%);'> <br> <br> Annotation colors
			</a>
		</div>
		<div style='min-width: 209px; width:25%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home10']; ?>">
			<a href="index.php?page=tutorial" class='btn btn-primary'> <img src="/img/tutorial.svg" style='height: 30px; filter: invert(90%);'> <br> <br> Tutorial
			</a>
		</div>
		<div style='min-width: 209px; width:25%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home11']; ?>">
			<a href="index.php?page=about" class='btn btn-primary'> <img src="/img/about.svg" style='height: 30px; filter: invert(90%);'> <br> <br> About us
			</a>
		</div>
		<div style='min-width: 209px; width:25%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home12']; ?>">
			<a href="index.php?page=database_configuration" class='btn btn-primary'> <img src="/img/config.svg" style='height: 30px; filter: invert(90%);'> <br> <br> Database configuration
			</a>
		</div>
		<div style='min-width: 209px; width:100%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home13']; ?>">
			<a href="index.php?page=platform_configuration" class='btn btn-primary'> <img src="/img/config.svg" style='height: 30px; filter: invert(90%);'> <br> <br>Platform configuration
			</a>
		</div>
	</div>
</div>
