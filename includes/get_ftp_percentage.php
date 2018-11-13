<?php
$TMP_DIR = dirname(dirname(dirname(__FILE__))) . "/tmp";
$link = $_GET['link'];
$name = basename($link);
$info = array();
exec("wget --spider $link -P /var/www/genotate/tmp 2>&1", $info);
foreach ($info as $line){
	if (substr_count($line,"SIZE")){
		$file_size = preg_replace('/[^0-9]+/', '', $line);
	}
}
$locel_size = filesize("$TMP_DIR/$name");
if($locel_size == 0){
	$locel_size = $file_size;
}
$progress = ($locel_size / $file_size)*100;
echo $progress;
?>