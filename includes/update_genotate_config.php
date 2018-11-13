<?php 
$text = "";
foreach($_POST as $key => $value){
	$text .= $key.":".$value."\n";
}
$genotate_dir = dirname(dirname(__DIR__));
$file_path = $genotate_dir . "/binaries/genotate.config";
file_put_contents($file_path, $text) or die ("failed to write config file $file_path");
?>