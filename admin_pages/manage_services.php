<script>
function update_genotate_config()
{
	var xhr = new XMLHttpRequest();
	xhr.open ("POST", "../includes/update_genotate_config.php", true);
	xhr.onreadystatechange = function() {
	    if(xhr.readyState == 4 && xhr.status == 200) {
			window.location.replace("/index.php?page=initialize");
	    }
	}
	var oFormElement = document.getElementById("form_genotate_config");
	xhr.send (new FormData (oFormElement));
}
</script>

<label type=title>Manage functional annotation services</label>
<p style='text-align: justify;text-justify: inter-word;'>
Services used for the identification of functional annotations can be managed here.
</p>
<br>

<div class="div-border-title">
	Installation information
	<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['manage_services']; ?>">
	<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="margin-bottom:10px;">
<?php
echo "<table style='width: 100%;' class='manage_tables'>";
echo "<thead><tr>";
echo ("<td style='width: 20%;'>service name</td>");
echo ("<td style='width: 10%;text-align:center;'>installed</td>");
echo ("<td>installation path</td>");
echo "</tr></thead>";
$genotate_dir = dirname(dirname(__DIR__));
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
			if (substr_count ( $service, "BLAST" ) == 0 && substr_count ( $service, "JAVA" ) == 0) {
				echo "<tr>";
					echo ("<td>$service</td>");
				if (!file_exists ( $file_path )) {
					echo ("<td><span style='text-align:center;background:#d9534f;color:white;width:100%;'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></span></td>");
				}else{
					$fileowner = posix_getpwuid(fileowner($file_path))['name'];
					if (strcmp($fileowner, "www-data") !== 0) {
						echo ("<td><span style='text-align:center;background:#d9534f;color:white;width:100%;'>owned by<br>$fileowner</span></td>");
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
}else{
	echo "<br>file not found $file_path";
}
echo "</table>";
?>
</div>
