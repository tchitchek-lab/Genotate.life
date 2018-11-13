<script>
function update_genotate_config()
{
	var xhr = new XMLHttpRequest();
	xhr.open ("POST", "../includes/update_genotate_config.php", true);
	xhr.onreadystatechange = function() {
	    if(xhr.readyState == 4 && xhr.status == 200) {
			window.location.reload();
	    }
	}
	var oFormElement = document.getElementById("form_genotate_config");
	xhr.send (new FormData (oFormElement));
}
function update_genotateweb_config()
{
  //var pass = prompt("password ?", "");
  //document.getElementById("PASS").value = pass;
	var xhr = new XMLHttpRequest();
	xhr.open ("POST", "../includes/update_genotateweb_config.php", true);
	xhr.onreadystatechange = function() {
	    if(xhr.readyState == 4 && xhr.status == 200) {
			window.location.reload();
	    }
	}
	var oFormElement = document.getElementById("form_genotateweb_config");
	xhr.send (new FormData (oFormElement));
}
</script>
<?php 
if(isset ($_POST['clean_tmp'])){
	$request = "SELECT * FROM dataset WHERE state = 'computing'";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	if(mysqli_num_rows($results) > 0){
		die("Datasets are currently computing, please try again later.");
	}
	$genotate_dir = dirname(dirname(__DIR__));
	$file_path = $genotate_dir . "/web/genotateweb.config.php";
	$paths = array();
	if ( file_exists($file_path) ) {
		$configfile = fopen($file_path, "r");
		while (!feof($configfile)) {
			$line = fgets($configfile);
			$line=rtrim($line);
			if ($line != ""){
				$splitline = explode(':', $line);
				$paths[$splitline[0]]=$splitline[1];
			}
		}
	}
	$dir = $paths['DIR_TMP']."/*";
	@array_map('unlink', glob($dir));
}

$file_path = $genotate_dir . "/binaries/genotate.config";
$genotatewebconfig = array();
$genotate_dir = dirname(dirname(__DIR__));
$file_path = $genotate_dir . "/web/genotateweb.config.php";
if (file_exists($file_path) ) {
	$configfile = fopen($file_path, "r");
	while (!feof($configfile)) {
		$line = fgets($configfile);
		$line=rtrim($line);
		if ($line != "" && strlen($line)>5){
			$splitline = explode(':', $line);
			$genotatewebconfig[$splitline[0]]=$splitline[1];
		}
	}
}

$genotate_dir = dirname(dirname(__DIR__));
$freespace = disk_free_space($genotate_dir)/(1000*1000);
$totalspace = disk_total_space($genotate_dir)/(1000*1000);
$usedspace = $totalspace - $freespace;
$space = floor(100 * $usedspace / $totalspace);
?>
<label type=title>Dependencies configuration</label>
<p style='text-align: justify; text-justify: inter-word;'>This page initialize the website and provides dependencies informations. In case of error please refer to Genotate.life github installation tutorial.</p>
<br>
<div class="div-border-title">
	Storage space:<?php echo " ".number_format ( $usedspace, 0, '.', ',' )." Mo used out of ".number_format ( $totalspace, 0, '.', ',' )." Mo" ?>
	<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['genotateweb_space']; ?>">
	<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="margin-bottom:10px;">
<?php
echo "<div class='progress' style='border:1px solid grey;margin-top:5px;margin-bottom:5px;padding:0;height:30px;width: 100%;'>";
echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='padding:5px;width: $space%;' aria-valuenow='$space' aria-valuemin='0' aria-valuemax='100'>".number_format ( $space, 0, '.', ', ' )."%</div>";
echo "</div>";
?>
<form method='post'>
<button type="submit" class="btn btn-default" style="width: 100%; font-size: 1.3em;" name='clean_tmp' <?php echo ($USER_MODE == 'restricted')?'disabled':''?>>clean temporary directory</button>
</form>
</div>
<div class="div-border-title">
	Web platform parameters
	<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['genotateweb_parameters']; ?>">
	<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="margin-bottom:10px;">
<form id='form_genotateweb_config' name='form_genotateweb_config' method='post'>
<!--<input type='hidden' id='PASS' name='PASS' value=''>-->
<?php
$file_path = $genotate_dir . "/binaries/genotate.config";
echo "<table style='width: 100%;' class='manage_tables'>";
echo "<thead><tr>";
echo ("<td style='width: 40%;'>parameter</td>");
echo ("<td align='right'>value </td>");
echo "</tr></thead>";
echo ("<tr><td>PARALLEL_REGIONS</td><td align='right'><input type='number' min=1 max=1000 value='".$genotatewebconfig['PARALLEL_REGIONS']."' style='width:100px;text-align:right;height:30px;' id='PARALLEL_REGIONS' name='PARALLEL_REGIONS' onchange='update_genotateweb_config()'");
echo ($USER_MODE == 'restricted')?'disabled':'';
echo ("></td></tr>");
echo ("<tr><td>PARALLEL_ANNOTATIONS</td><td align='right'><input type='number' min=1 max=1000 value='".$genotatewebconfig['PARALLEL_ANNOTATIONS']."' style='width:100px;text-align:right;height:30px;' id='PARALLEL_ANNOTATIONS' name='PARALLEL_ANNOTATIONS' onchange='update_genotateweb_config()' ");
echo ($USER_MODE == 'restricted')?'disabled':'';
echo ("></td></tr>");
echo ("<tr><td>PARALLEL_BLAST_PROCESS</td><td align='right'><input type='number' min=1 max=1000 value='".$genotatewebconfig['PARALLEL_BLAST_PROCESS']."' style='width:100px;text-align:right;height:30px;' id='PARALLEL_BLAST_PROCESS' name='PARALLEL_BLAST_PROCESS' onchange='update_genotateweb_config()' ");
echo ($USER_MODE == 'restricted')?'disabled':'';
echo ("></td></tr>");
//echo ("<tr><td>USER_MODE</td><td align='right'><select class='multiple' type='text' style='width:100px;height:30px;padding:2px;' id='USER_MODE' name='USER_MODE' onchange='update_genotateweb_config()'>");
//if($genotatewebconfig['USER_MODE'] == "normal"){
//	echo ("<option selected>normal");
//}else{
//	echo ("<option>normal");
//}
//if($genotatewebconfig['USER_MODE'] == "debug"){
//	echo ("<option selected>debug");
//}else{
//	echo ("<option>debug");
//}
//if($genotatewebconfig['USER_MODE'] == "restricted"){
//	echo ("<option selected>restricted</select></td>");
//}else{
//	echo ("<option>restricted</select></td>");
//}
//echo "</tr>";
echo "</table>";
?>
</div>
<div class="div-border-title">
	Web platform dependencies information
	<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['genotateweb_config']; ?>">
	<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="margin-bottom:10px;">
<?php
$file_path = $genotate_dir . "/binaries/genotate.config";
echo "<table style='width: 100%;' class='manage_tables'>";
echo "<thead><tr>";
echo ("<td style='width: 30%;'>name</td>");
echo ("<td style='width: 10%;text-align:center;'>available</td>");
echo ("<td>local path</td>");
echo "</tr></thead>";
foreach($genotatewebconfig AS $service => $file_path){
	if($service == "PARALLEL_REGIONS" || $service == "PARALLEL_ANNOTATIONS" || $service == "PARALLEL_BLAST_PROCESS" || $service == "USER_MODE" || $service == "PASS"){
		continue;
	}
	if (substr_count ( $service, "DIR_" ) > 0){
		if (!file_exists ( $file_path )) {
			mkdir ( $file_path );
		}
	}
	if (substr_count ( $service, "GENOTATE" ) > 0){
		if (! file_exists ( $file_path )) {
			exec ( "wget https://github.com/tchitchek-lab/genotate/raw/master/genotate.jar -P " . $file_path);
		}
	}
	if (substr_count ( $service, "GENOTATE_CONFIG" ) > 0){
		if (! file_exists ( $file_path )) {
			exec ( "wget https://github.com/tchitchek-lab/genotate/raw/master/genotate.config -P " . $file_path );
		}
	}
	echo "<tr>";
		echo ("<td>$service</td>");
	if (!file_exists ( $file_path )) {
		echo ("<td><span style='text-align:center;background:#d9534f;color:white;width:100%;'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></span></td>");
	}else{
		$fileowner = posix_getpwuid(fileowner($file_path))['name'];
		if (strcmp($fileowner, "www-data") !== 0) {
			echo ("<td><span style='text-align:center;background:#d9534f;color:white;width:100%;'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&emsp;owned by $fileowner</span></td>");
		}else{
			echo ("<td><span style='text-align:center;background:#5cb85c;color:white;width:100%;'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></span></td>");
		}
	}
	echo ("<td><input type='text' value='$file_path' style='width:100%' id='$service' name='$service' onchange='update_genotateweb_config()' ");
echo ($USER_MODE == 'restricted')?'disabled':'';
echo ("></td>");
	echo "</tr>";
}
echo "</table>";
?>
</form>
</div>

<div class="div-border-title">
	Annotation pipeline dependencies information
	<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['genotate_config']; ?>">
	<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="margin-bottom:10px;">
<form id='form_genotate_config' name='form_genotate_config' method='post'>
<?php
$genotate_dir = dirname(dirname(__DIR__));
$file_path = $genotate_dir . "/binaries/genotate.config";
echo "<table style='width: 100%;' class='manage_tables'>";
echo "<thead><tr>";
echo ("<td style='width: 30%;'>name</td>");
echo ("<td style='width: 10%;text-align:center;'>available</td>");
echo ("<td>local path</td>");
echo "</tr></thead>";
$file_path = $genotate_dir . "/binaries/genotate.config";
if ( file_exists($file_path) ) {
	$configfile = fopen($file_path, "r");
	while (!feof($configfile)) {
		$line = fgets($configfile);
		$line=rtrim($line);
		if ($line != ""){
			$splitline = explode(':', $line);
			$service = $splitline[0];
			$file_path = $splitline[1];
			echo "<tr>";
			echo ("<td>$service</td>");
			if (!file_exists ( $file_path )) {
				echo ("<td><span style='text-align:center;background:#d9534f;color:white;width:100%;'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></span></td>");
			}else{
				$fileowner = posix_getpwuid(fileowner($file_path))['name'];
				if (strcmp($fileowner, "www-data") !== 0) {
					echo ("<td><span style='text-align:center;background:#d9534f;color:white;width:100%;'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>&emsp;owned by $fileowner</span></td>");
				}else{
					echo ("<td><span style='text-align:center;background:#5cb85c;color:white;width:100%;'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></span></td>");
				}
			}
			if ($USER_MODE != "restricted") {
				echo ("<td><input type='text' value='$file_path' style='width:100%' id='$service' name='$service' onchange='update_genotate_config()'></td>");
			}else{
				echo ("<td>$file_path</td>");
			}
			echo "</tr>";
		}
	}
}
echo "</table>";
?>
</form>
</div>
