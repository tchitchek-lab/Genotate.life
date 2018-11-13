<center>
	<label class="title_genotate" href='./'>Genotate</label>
	<br>
	<label style='font-size: 20px;' href='./'>
		annotating and exploring transcriptomic sequences
	</label>
</center>
<br>
<p style='font-size: 16px; text-align: justify; text-justify: inter-word;'>The Genotate platform is a web-based interactive environment to automatically identify, explore and visualize homology and functional annotations for assembled transcripts. Its aims to provide a way for bioinformaticians, systems biologists, and experimental biologists a way to unify transcriptomic information obtained from various predictive algorithms and databases for a given set of transcripts.</p>
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



<p>
<?php if($user->isLoggedIn()){$uid = $user->data()->id;?>
  <a class="btn btn-primary" href="users/account.php" role="button">User Account &raquo;</a>
<?php }else{?>
  <a class="btn btn-warning" href="users/login.php" role="button" data-toggle="tooltip" title="<?php echo $tooltip_text['signin']; ?>">Sign In &raquo;</a>
  <a class="btn btn-info" href="users/join.php" role="button" data-toggle="tooltip" title="<?php echo $tooltip_text['signup']; ?>">Sign Up &raquo;</a>
<?php } ?>
</p>
<br>

<div class="div-border-title" style='width: 100%;'>Genotate functionalities</div>
<div class="div-border" style='width: 100%;'>
	<div style='width: 100%; margin-top: 2px;'>
		<div style='min-width: 209px; width:50%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home1']; ?>">
			<a href="index.php?page=annotate_single_transcript" class='btn btn-primary'> <img src="/img/seq.svg" style='height: 30px; filter: invert(90%);'> <br> <br> Annotate a single transcript
			</a>
		</div>
		<div style='min-width: 209px; width:50%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home2']; ?>">
			<a href="index.php?page=annotate_multiple_transcripts" class='btn btn-primary'> <img src="/img/seq.svg" style='height: 30px; filter: invert(90%);'><img src="/img/seq.svg" style='height: 30px; filter: invert(100%);'> <br> <br> Annotate multiple transcripts
			</a>
		</div>
		<div style='min-width: 209px; width:50%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home3']; ?>">
			<a href="index.php?page=search_annotations" class='btn btn-primary'> <img src="/img/search.svg" style='height: 30px; filter: invert(90%);'> <br> <br> Explore annotation results
			</a>
		</div>
		<div style='min-width: 209px; width:50%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home4']; ?>">
			<a href="index.php?page=manage_annotations" class='btn btn-primary'> <img src="/img/database.svg" style='height: 30px; filter: invert(90%);'> <br> <br> Manage annotation results
			</a>
		</div>
		<div style='min-width: 209px; width:50%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home10']; ?>">
			<a href="index.php?page=tutorial" class='btn btn-primary'> <img src="/img/tutorial.svg" style='height: 30px; filter: invert(90%);'> <br> <br> Help and tutorial
			</a>
		</div>
		<div style='min-width: 209px; width:50%;padding: 2px;' data-toggle="tooltip" data-placement="bottom" title="<?php echo $tooltip_text['home11']; ?>">
			<a href="index.php?page=about" class='btn btn-primary'> <img src="/img/about.svg" style='height: 30px; filter: invert(90%);'> <br> <br> About
			</a>
		</div>
	</div>
</div>
