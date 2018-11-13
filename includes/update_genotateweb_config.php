<?php 
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

//if($paths['PASS'] != $_POST['PASS']){return false;}

$text = "<?php\n";
foreach($_POST as $key => $value){
	$text .= $key.":".$value."\n";
}
$text .= "?>";
file_put_contents($file_path, $text) or die ("failed to write config file $file_path");
?>